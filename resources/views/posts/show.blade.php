@extends('layouts.app')

@section('title', $post->title . ' | Barangay Bulletin')

@section('content')
    <main class="mx-auto max-w-3xl space-y-6 px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('posts.index') }}" class="text-sm font-medium text-blue-700 hover:text-blue-900">
            &larr; Back to posts
        </a>

        <article class="space-y-6 rounded-lg border border-slate-200 bg-white p-6">
            <header class="space-y-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                        {{ $post->category }}
                    </span>

                    @if ($post->is_pinned)
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-medium text-amber-800">
                            Pinned
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl font-bold tracking-tight">{{ $post->title }}</h1>

                <p class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
                    @if ($post->published_at)
                        <time datetime="{{ $post->published_at->toAtomString() }}">
                            {{ $post->published_at->format('M j, Y') }}
                        </time>
                    @else
                        <span>Date unavailable</span>
                    @endif
                    <span aria-hidden="true">&middot;</span>
                    <span>{{ number_format($post->views) }} {{ $post->views === 1 ? 'view' : 'views' }}</span>
                </p>
            </header>

            <div class="whitespace-pre-line leading-7 text-slate-700">{{ $post->body }}</div>
        </article>
    </main>
@endsection
