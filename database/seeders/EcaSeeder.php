<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eca;

class EcaSeeder extends Seeder
{
    public function run(): void
    {
        $ecas = [
            [
                'title' => 'Rebellion Club',
                'category' => 'Music & Arts',
                'level' => 'All Levels',
                'instructor' => 'Alex Turner',
                'short_description' => 'Express yourself through modern music and unconventional arts.',
                'full_description' => 'The Rebellion Club is for those who dare to be different. We focus on modern music production, street art, and alternative forms of expression. Members collaborate on unique projects that challenge traditional artistic boundaries.',
                'thumbnail' => '/landing/images/clubs/club1.png',
            ],
            [
                'title' => 'Painting Club',
                'category' => 'Visual Arts',
                'level' => 'Beginner to Intermediate',
                'instructor' => 'Elena Rossi',
                'short_description' => 'Master the strokes of classical and contemporary painting.',
                'full_description' => 'Unleash your inner artist in our Painting Club. We explore various mediums including oil, watercolor, and acrylics. Weekly sessions include guided tutorials, free-painting hours, and guest lectures from local artists.',
                'thumbnail' => '/landing/images/clubs/club2.png',
            ],
            [
                'title' => 'Creative Writing Club',
                'category' => 'Literature',
                'level' => 'All Levels',
                'instructor' => 'Julian Barnes',
                'short_description' => 'Craft compelling stories, poetry, and scripts.',
                'full_description' => 'The Creative Writing Club provides a supportive environment for writers of all genres. We host workshops on character development, plot structure, and world-building. Join us to turn your ideas into literary masterpieces.',
                'thumbnail' => '/landing/images/clubs/club3.png',
            ],
            [
                'title' => 'Foreign Language Club',
                'category' => 'Linguistics',
                'level' => 'Introductory',
                'instructor' => 'Maria Gonzalez',
                'short_description' => 'Broaden your horizons by learning new languages and cultures.',
                'full_description' => 'Dive into the world of linguistics and multiculturalism. Our Foreign Language Club offers introductory courses in Spanish, French, and Japanese. We combine language lessons with cultural activities like food tasting and film screenings.',
                'thumbnail' => '/landing/images/clubs/club4.png',
            ],
        ];

        foreach ($ecas as $eca) {
            Eca::updateOrCreate(
                ['title' => $eca['title']],
                $eca
            );
        }
    }
}
?>