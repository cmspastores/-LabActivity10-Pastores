<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::all();
        $kagawad = Author::where('name', 'Juan Dela Cruz')
            ->where('position', 'Kagawad')
            ->firstOrFail();

        Post::create([
            'author_id' => $kagawad->id,
            'title' => 'Happy Birthday!',
            'category' => 'Announcement',
            'body' => 'Wishing everyone a joyful birthday celebration.',
            'is_published' => true,
            'is_pinned' => true,
            'published_at' => '2026-09-16 00:00:00',
        ]);

        Post::factory()->count(40)
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();

        Post::factory()->count(10)->draft()
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();
    }
}
