@extends('layouts.app')

@section('title', 'Posts | Barangay Bulletin')

@section('content')
    <main class="mx-auto max-w-4xl space-y-8 px-4 py-10 sm:px-6 lg:px-8">
        <header class="space-y-2">
            <h1 class="text-3xl font-bold tracking-tight">Barangay Bulletin</h1>
            <p class="text-slate-600">Announcements and updates from Purok Pastores.</p>
        </header>

        <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col gap-3 rounded-lg border border-slate-200 bg-white p-4 sm:flex-row">
            <div class="flex-1">
                <label for="q" class="mb-1 block text-sm font-medium">Search posts</label>
                <input
                    id="q"
                    name="q"
                    type="search"
                    value="{{ request('q') }}"
                    placeholder="Search title"
                    class="w-full rounded-md border border-slate-300 px-3 py-2"
                >
            </div>

            <div>
                <label for="category" class="mb-1 block text-sm font-medium">Category</label>
                <select id="category" name="category" class="w-full rounded-md border border-slate-300 px-3 py-2">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="rounded-md bg-blue-700 px-4 py-2 font-medium text-white hover:bg-blue-800">
                    Filter
                </button>
            </div>
        </form>

        <section aria-label="Posts" class="space-y-4">
            @forelse ($posts as $post)
                <article class="space-y-3 rounded-lg border border-slate-200 bg-white p-5">
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

                    <h2 class="text-xl font-semibold">
                        <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="text-slate-900 hover:text-blue-700">
                            {{ $post->title }}
                        </a>
                    </h2>

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
                </article>
            @empty
                <p role="status" class="rounded-lg border border-slate-200 bg-white p-5 text-slate-600">
                    No posts match your search.
                </p>
            @endforelse
        </section>

        @if ($posts->hasPages())
            <nav aria-label="Post pages">
                {{ $posts->links() }}
            </nav>
        @endif

        @if ($posts->total() > 0)
            <p class="text-sm text-slate-600">
                Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts
            </p>
        @endif
    </main>
@endsection