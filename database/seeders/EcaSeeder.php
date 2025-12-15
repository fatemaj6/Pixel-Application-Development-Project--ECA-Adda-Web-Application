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
                'title' => 'AI & Machine Learning Club',
                'category' => 'Technology',
                'level' => 'Beginner',
                'instructor' => 'Dr. Sarah Lee',
                'short_description' => 'Learn the basics of AI and ML through hands-on projects.',
                'full_description' => 'This ECA introduces students to artificial intelligence, machine learning models, and practical applications using Python.',
                'thumbnail' => '/eca-images/ai.webp',
            ],
            [
                'title' => 'Robotics & Automation',
                'category' => 'Engineering',
                'level' => 'Intermediate',
                'instructor' => 'Engr. Aiman Rahman',
                'short_description' => 'Build and program robots from scratch.',
                'full_description' => 'Students work with Arduino and Raspberry Pi to build autonomous robots and automation systems.',
                'thumbnail' => '/eca-images/robotics.webp',
            ],
            [
                'title' => 'Public Speaking & Leadership',
                'category' => 'Soft Skills',
                'level' => 'Beginner',
                'instructor' => 'Ms. Nur Aisyah',
                'short_description' => 'Improve confidence and leadership skills.',
                'full_description' => 'Focuses on communication, presentation, and leadership development through weekly activities.',
                'thumbnail' => '/eca-images/publicSpeaking.jpg',
            ],
            [
                'title' => 'Entrepreneurship Bootcamp',
                'category' => 'Business',
                'level' => 'Advanced',
                'instructor' => 'Mr. Daniel Wong',
                'short_description' => 'Turn ideas into startups.',
                'full_description' => 'Learn business models, pitching, and startup funding from industry mentors.',
                'thumbnail' => '/eca-images/enterpreneurship.jpg',
            ],
        ];

        foreach ($ecas as $eca) {
            Eca::create($eca);
        }
    }
}
?>