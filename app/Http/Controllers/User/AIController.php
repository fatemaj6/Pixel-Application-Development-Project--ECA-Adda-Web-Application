<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Eca;
use App\Http\Controllers\Controller;

class AIController extends Controller
{
    /**
     * Show the AI Advisor chat page.
     */
    public function index()
    {
        return view('dashboard.aidash');
    }

    /**
     * Handle chat requests and return Gemini AI response.
     */
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (empty($userMessage)) {
            return response()->json([
                'reply' => 'Please enter a message before sending.'
            ], 400);
        }

        try {
            $user = $request->user();
            $ecas = Eca::query()
                ->select('id', 'title', 'category', 'level', 'instructor', 'short_description', 'full_description')
                ->orderBy('title')
                ->get();

            if ($this->isRecommendationRequest($userMessage)) {
                $reply = $this->buildRecommendationReply($userMessage, $user, $ecas, $request);
                return response()->json(['reply' => $reply]);
            }

            if ($this->isEcaDetailRequest($userMessage, $ecas)) {
                $reply = $this->buildEcaDetailReply($userMessage, $request, $ecas);
                return response()->json(['reply' => $reply]);
            }

            $systemPrompt = $this->buildAdvisorPrompt($user, $ecas);

            $url = config('services.gemini.endpoint') . '/' .
                   config('services.gemini.model') . ':generateContent?key=' .
                   config('services.gemini.key');

            $payload = [
                'contents' => [[
                    'role' => 'user',
                    'parts' => [[ 'text' => $systemPrompt . "\n\nUser message: {$userMessage}" ]],
                ]],
                'generationConfig' => [
                    'temperature' => 0.3,
                    'maxOutputTokens' => 512,
                ],
            ];

            $response = Http::post($url, $payload);

            if ($response->failed()) {
                Log::error('Gemini API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return response()->json([
                    'reply' => 'Sorry, the AI service is currently unavailable. Please try again later.'
                ], 500);
            }

            $json = $response->json();
            Log::info('Gemini chat response:', $json);

            $parts = data_get($json, 'candidates.0.content.parts', []);
            $reply = collect($parts)->pluck('text')->implode("\n");

            if (empty($reply)) {
                Log::warning('Gemini returned no reply', ['message' => $userMessage]);
                $reply = 'Sorry, I didn’t catch that. Can you rephrase or ask something else?';
            }

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('Gemini chat exception', ['error' => $e->getMessage()]);

            return response()->json([
                'reply' => 'An unexpected error occurred while contacting the AI service.'
            ], 500);
        }
    }

    private function buildAdvisorPrompt($user, $ecas): string
    {
        $educationLevel = $user?->education_level ?: 'unknown';
        $interests = $user?->interests;
        $interestsList = (is_array($interests) && count($interests))
            ? implode(', ', $interests)
            : 'not provided';

        $ecaLines = $ecas->map(function ($eca) {
            $category = $eca->category ?: 'General';
            $level = $eca->level ?: 'Beginner';
            $instructor = $eca->instructor ?: 'TBA';
            $description = $eca->short_description ?: $eca->full_description ?: 'No description provided.';
            return "- {$eca->title} | Category: {$category} | Level: {$level} | Instructor: {$instructor} | {$description}";
        })->implode("\n");

        if ($ecaLines === '') {
            $ecaLines = 'None listed.';
        }

        return implode("\n", [
            'You are the ECA Adda AI Advisor.',
            'Use only the ECAs listed under Available ECAs. Do not invent or rename ECAs.',
            'If the user asks about ECAs that are not listed, say they are not currently offered and suggest the closest match from the list.',
            'When the user asks for recommendations, reply with: "Based on your preferences, these ECAs will suit you:" followed by a numbered list of 3-5 ECA titles.',
            'When the user asks for more details about a specific ECA, respond with: "This ECA is of difficulty level {low/intermediate/high} and it is taught by {instructor name}."',
            'Map difficulty from level: Beginner -> low, Intermediate -> intermediate, Advanced -> high.',
            'Match suggestions to the user\'s interests and education level. Prefer details from the user\'s message over the profile if they conflict.',
            'If interests or education level are missing, ask one short follow-up question before recommending.',
            'Do not list the full catalog unless the user asks for it.',
            'Keep responses concise and plain text.',
            'Education level guidance:',
            '- grade6-8: prioritize Beginner; avoid Advanced unless explicitly requested.',
            '- grade9-10: prioritize Beginner and Intermediate; avoid Advanced unless explicitly requested.',
            '- grade11-12: prioritize Intermediate and Advanced.',
            '- gap-year: prioritize Intermediate and Advanced with career/portfolio focus.',
            '',
            'User profile:',
            "- Education level: {$educationLevel}",
            "- Interests: {$interestsList}",
            '',
            'Available ECAs:',
            $ecaLines,
        ]);
    }

    private function isRecommendationRequest(string $message): bool
    {
        $message = strtolower($message);
        $keywords = [
            'recommend',
            'recommendation',
            'suggest',
            'suggestion',
            'eca for',
            'which eca',
            'what eca',
            'best eca',
            'join',
            'enroll',
            'pick',
            'choose',
        ];

        foreach ($keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    private function isEcaDetailRequest(string $message, $ecas): bool
    {
        $message = strtolower($message);
        $hasGenericEcaReference = str_contains($message, 'eca')
            || str_contains($message, 'club')
            || str_contains($message, 'activity');

        if (str_contains($message, 'this eca')
            || str_contains($message, 'this club')
            || str_contains($message, 'this activity')
        ) {
            return true;
        }

        foreach ($ecas as $eca) {
            $title = strtolower((string) $eca->title);
            if ($title !== '' && str_contains($message, $title)) {
                return true;
            }
        }

        $detailKeywords = [
            'tell me more',
            'more about',
            'details',
            'detail',
            'difficulty',
            'instructor',
            'teacher',
            'coach',
        ];

        if ($hasGenericEcaReference) {
            foreach ($detailKeywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function buildEcaDetailReply(string $message, Request $request, $ecas): string
    {
        $eca = $this->findEcaInMessage($message, $ecas);

        if (! $eca) {
            $lastEcaId = $request->session()->get('ai_last_eca_id');
            if ($lastEcaId) {
                $eca = $ecas->firstWhere('id', $lastEcaId);
            }
        }

        if (! $eca) {
            $lastRecommendations = $request->session()->get('ai_last_recommendations', []);
            if (! empty($lastRecommendations)) {
                $eca = $ecas->firstWhere('id', $lastRecommendations[0]);
            }
        }

        if (! $eca) {
            return 'Which ECA would you like to know more about? Please mention its name.';
        }

        $request->session()->put('ai_last_eca_id', $eca->id);

        $difficulty = $this->difficultyForLevel($eca->level);
        $instructor = $eca->instructor ?: 'TBA';

        return "This ECA is of difficulty level {$difficulty} and it is taught by {$instructor}.";
    }

    private function findEcaInMessage(string $message, $ecas): ?Eca
    {
        $message = strtolower($message);

        return $ecas->first(function ($eca) use ($message) {
            $title = strtolower((string) $eca->title);
            return $title !== '' && str_contains($message, $title);
        });
    }

    private function buildRecommendationReply(string $message, $user, $ecas, Request $request): string
    {
        $educationLevel = $user?->education_level;
        $allowedLevels = $this->allowedLevelsForEducation($educationLevel);
        $keywords = $this->collectInterestKeywords($message, $user?->interests ?? []);

        if (empty($keywords) && empty($educationLevel)) {
            return 'Tell me your interests and education level so I can recommend ECAs.';
        }

        if (empty($keywords)) {
            return 'Tell me a few interests and I will recommend ECAs that fit your level.';
        }

        $scored = $ecas->map(function ($eca) use ($keywords) {
            $title = strtolower((string) $eca->title);
            $category = strtolower((string) ($eca->category ?? ''));
            $shortDescription = strtolower((string) ($eca->short_description ?? ''));
            $fullDescription = strtolower((string) ($eca->full_description ?? ''));
            $level = $this->normalizeLevel($eca->level);

            $score = 0;

            foreach ($keywords as $keyword) {
                if ($keyword === '') {
                    continue;
                }

                if (str_contains($title, $keyword)) {
                    $score += 3;
                }

                if (str_contains($category, $keyword)) {
                    $score += 2;
                }

                if (str_contains($shortDescription, $keyword) || str_contains($fullDescription, $keyword)) {
                    $score += 1;
                }
            }

            return [
                'id' => $eca->id,
                'title' => (string) $eca->title,
                'normalized_level' => $level,
                'score' => $score,
            ];
        });

        $matches = $scored->filter(fn ($eca) => $eca['score'] > 0);
        $levelMatches = $matches->filter(function ($eca) use ($allowedLevels) {
            if (empty($allowedLevels)) {
                return true;
            }
            return in_array($eca['normalized_level'], $allowedLevels, true);
        });

        if ($levelMatches->isEmpty()) {
            if ($matches->isNotEmpty() && !empty($allowedLevels)) {
                return 'I found ECAs related to your interests, but they may be above your current level. Want to see them anyway?';
            }

            $categories = $ecas
                ->pluck('category')
                ->filter()
                ->unique()
                ->values()
                ->all();

            if (!empty($categories)) {
                $categoryList = implode(', ', $categories);
                return "I do not see a matching ECA for that interest right now. Are you interested in any of these areas: {$categoryList}?";
            }

            return 'I do not see a matching ECA for that interest right now. Tell me another interest and I will suggest options.';
        }

        $recommendations = $levelMatches
            ->sortByDesc('score')
            ->take(5)
            ->values();

        $this->storeRecommendationContext($recommendations, $request);

        $lines = ['Based on your preferences, these ECAs will suit you:'];
        foreach ($recommendations as $index => $eca) {
            $lines[] = sprintf('%d) %s', $index + 1, $eca['title']);
        }

        return implode("\n", $lines);
    }

    private function storeRecommendationContext($recommendations, Request $request): void
    {
        $ids = $recommendations->pluck('id')->values()->all();
        $request->session()->put('ai_last_recommendations', $ids);
        $request->session()->put('ai_last_eca_id', $ids[0] ?? null);
    }

    private function difficultyForLevel(?string $level): string
    {
        return match ($this->normalizeLevel($level)) {
            'advanced' => 'high',
            'intermediate' => 'intermediate',
            'beginner' => 'low',
            default => 'intermediate',
        };
    }

    private function allowedLevelsForEducation(?string $educationLevel): array
    {
        if (empty($educationLevel)) {
            return [];
        }

        return match ($educationLevel) {
            'grade6-8' => ['beginner'],
            'grade9-10' => ['beginner', 'intermediate'],
            'grade11-12' => ['intermediate', 'advanced'],
            'gap-year' => ['intermediate', 'advanced'],
            default => [],
        };
    }

    private function normalizeLevel(?string $level): string
    {
        $level = strtolower((string) $level);

        if (str_contains($level, 'advanced')) {
            return 'advanced';
        }
        if (str_contains($level, 'intermediate')) {
            return 'intermediate';
        }
        if (str_contains($level, 'beginner')) {
            return 'beginner';
        }

        return 'beginner';
    }

    private function collectInterestKeywords(string $message, $interests): array
    {
        $keywords = $this->extractKeywords($message);

        if (is_array($interests)) {
            foreach ($interests as $interest) {
                $keywords = array_merge($keywords, $this->extractKeywords((string) $interest));
            }
        }

        $keywords = array_values(array_unique($keywords));

        return $keywords;
    }

    private function extractKeywords(string $text): array
    {
        $tokens = preg_split('/[^a-z0-9]+/i', strtolower($text), -1, PREG_SPLIT_NO_EMPTY);
        $stopwords = [
            'a', 'an', 'the', 'and', 'or', 'of', 'to', 'in', 'for', 'with', 'about',
            'i', 'im', 'me', 'my', 'we', 'our', 'you', 'your',
            'recommend', 'recommendation', 'suggest', 'suggestion', 'eca', 'ecas',
            'activity', 'activities', 'club', 'clubs', 'like', 'love', 'want', 'need',
            'please', 'help', 'interested', 'interest', 'looking', 'best', 'join',
        ];

        $keywords = [];
        foreach ($tokens as $token) {
            if (strlen($token) < 3 || in_array($token, $stopwords, true)) {
                continue;
            }
            $keywords[] = $token;
        }

        return $keywords;
    }
}
?>
