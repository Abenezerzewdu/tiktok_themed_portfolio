<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Project::create([
        'title' => 'TikTok Portfolio',
        'slug' => 'tiktok-portfolio',
        'description' => 'A vertical scroll portfolio inspired by TikTok UI.',
        'video_url' => '/storage/videos/sample.mp4',
        'thumbnail_url' => null,
        'github_url' => 'https://github.com/yourname/project',
        'live_url' => null,
        'tech_stack' => ['Laravel', 'Vue', 'Inertia'],
        'is_published' => true,
    ]);

    Project::create([
        'title' => 'E-commerce App',
        'slug' => 'ecommerce-app',
        'description' => 'Fullstack MERN-style e-commerce built with Laravel.',
        'video_url' => '/storage/videos/sample2.mp4',
        'tech_stack' => ['Laravel', 'Vue'],
        'is_published' => true,
    ]);
    }
}
