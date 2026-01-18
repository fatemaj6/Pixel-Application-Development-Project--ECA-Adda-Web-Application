<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Eca;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first();

        if (! $author) {
            $author = User::query()->create([
                'name' => 'Seed Author',
                'email' => 'seed.author@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        $ecas = Eca::query()->orderBy('id')->get();

        if ($ecas->isEmpty()) {
            return;
        }

        $ecas = $ecas->values();
        $blogPasts = [
            'Rebellion Club' => [
                'title' => 'Beyond the Canvas: The Spirit of the Rebellion Club',
                'excerpt' => 'Discover how our members are redefining modern art through music and street murals.',
                'content' => "The Rebellion Club isn't just about making noise; it's about making a statement.\n\nFrom the high-energy pulse of electronic music production to the large-scale storytelling of street art, we provide a space for students to experiment without boundaries. This month, we've been working on a collaborative mural that combines digital projection with traditional spray painting.\n\nJoin us every Friday to share your vision and collaborate with like-minded rebels.",
            ],
            'Painting Club' => [
                'title' => 'Mastering the Light: A Guide for Young Painters',
                'excerpt' => 'Learn the secrets of color theory and light from our Painting Club sessions.',
                'content' => "Painting is more than just putting brush to canvas; it's about seeing the world in a different light.\n\nIn our latest workshop, Elena Rossi demonstrated how to capture the golden hour using oil glazes. Whether you're a complete beginner or an experienced artist, our club offers the tools and community you need to grow. We're currently preparing for the annual regional showcase, and we want your work to be there!\n\nStop by the art studio on Tuesdays and Thursdays.",
            ],
            'Creative Writing Club' => [
                'title' => 'Finding Your Voice: From Blank Page to Masterpiece',
                'excerpt' => 'How the Creative Writing Club helps students overcome writer\'s block and finish their novels.',
                'content' => "Every great story starts with a single word. At the Creative Writing Club, we help you find that word and the thousand that follow it.\n\nOur weekly workshops cover everything from the 'Hero's Journey' to experimental poetry. We also hold 'blind peer review' sessions which have become a favorite among our members. This semester, we are focusing on world-building in speculative fiction.\n\nIf you have a story to tell, we have the community to help you tell it better.",
            ],
            'Foreign Language Club' => [
                'title' => 'Language as a Bridge: Connecting Cultures through Speech',
                'excerpt' => 'Why learning a new language is the ultimate way to broaden your horizons.',
                'content' => "Learning a language is like gaining a second soul. The Foreign Language Club is your passport to new worlds.\n\nThis week, our Spanish students hosted a 'Tapas & Talk' night where we practiced conversational skills while sampling authentic cuisine. Next week, we transition to our French cinema series. Language is more than grammar; it's the music of culture.\n\nCome learn with us and prepare for a truly global future.",
            ],
        ];

        foreach ($blogPasts as $ecaTitle => $data) {
            $eca = Eca::where('title', $ecaTitle)->first();
            if (!$eca) continue;

            if (Blog::query()->where('title', $data['title'])->exists()) {
                continue;
            }

            $blog = new Blog();
            $blog->title = $data['title'];
            $blog->excerpt = $data['excerpt'];
            $blog->content = $data['content'];
            $blog->thumbnail = $eca->thumbnail; // Use the ECA's image for the blog too
            $blog->author_id = $author->id;
            $blog->save();
        }
    }
}
