<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the post list shows published post details and pinned status', function () {
    $pinnedPost = Post::factory()->create([
        'title' => 'Community clean-up on Saturday',
        'category' => 'Announcement',
        'published_at' => '2026-11-09 08:00:00',
        'views' => 42,
        'is_pinned' => true,
    ]);

    Post::factory()->create([
        'title' => 'Clinic schedule update',
        'is_pinned' => false,
    ]);

    Post::factory()->draft()->create([
        'title' => 'Unpublished draft',
    ]);

    $response = $this->get(route('posts.index'));

    $response->assertOk()
        ->assertSee('Community clean-up on Saturday')
        ->assertSee(route('posts.show', ['id' => $pinnedPost->id]))
        ->assertSee('Announcement')
        ->assertSee('Nov 9, 2026')
        ->assertSee('42 views')
        ->assertSee('Pinned')
        ->assertSee('Clinic schedule update')
        ->assertDontSee('Unpublished draft');

    expect(substr_count($response->getContent(), 'Pinned'))->toBe(1);
});

test('a post link opens the post page and records a view', function () {
    $post = Post::factory()->create([
        'title' => 'Neighborhood meeting',
        'body' => 'The meeting starts at six.',
        'category' => 'Announcement',
        'views' => 3,
    ]);

    $response = $this->get(route('posts.show', ['id' => $post->id]));

    $response->assertOk()
        ->assertSee('Neighborhood meeting')
        ->assertSee('The meeting starts at six.')
        ->assertSee('Announcement')
        ->assertSee('4 views');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'views' => 4,
    ]);
});

test('a draft post cannot be viewed', function () {
    $draftPost = Post::factory()->draft()->create([
        'views' => 3,
    ]);

    $response = $this->get(route('posts.show', ['id' => $draftPost->id]));

    $response->assertNotFound();

    $this->assertDatabaseHas('posts', [
        'id' => $draftPost->id,
        'views' => 3,
    ]);
});
