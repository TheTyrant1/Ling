@extends('web::blade.layouts.web')

@php
    use App\Models\Post;
    use Illuminate\Support\Number;
@endphp

@section('content')
    <main class="blog-container">

        <div class="tag-page-text-container" data-aos="fade-up">
            <h1 class="tag-page-title">#{{ $tag->title }}</h1>

            @if($posts->count() > 1)
                <p class="tag-page-subtitle">
                    Posts: {{ $tag->posts->count() }}
                </p>
            @endif
        </div>

        {{-- Блок сортування --}}
        @if($posts->count() > 1)
            <div class="blog-filter-bar" data-aos="fade-up">
                <form method="GET" action="{{ route('post.index') }}">
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="latest" {{ (request('sort') == 'latest') ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ (request('sort') == 'popular') ? 'selected' : '' }}>Popular</option>
                    </select>
                </form>
            </div>
        @endif

        {{-- Сітка постів --}}
        @if($posts->count())
            <section class="blog-grid">
                @foreach($posts as $post)
                    <article class="blog-post" data-aos="fade-up">

                        {{-- Обгортка зображення та автора --}}
                        <div class="post-media">
                            <a href="{{ route('user.show', $post->user->id) }}" class="author-badge">
                                <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="User image">
                                <span title="{{ $post->user->name }}">{{ Str::limit($post->user->name, 10) }}</span>
                            </a>
                            <a href="{{ route('post.show', $post->id) }}">
                                <img src="{{ asset('storage/' . $post->preview_image) }}" alt="{{ $post->title }}" class="post-preview-img">
                            </a>
                        </div>

                        {{-- Мета-дані (Теги та Дата) --}}
                        <div class="post-meta">
                            @if($post->tags->count())
                                <div class="post-tags">
                                    @foreach($post->tags->take(2) as $tag)
                                        <a href="{{ route('tag.index', $tag->id) }}" class="tag-item">#{{ Str::limit($tag->title, 10) }}</a>
                                    @endforeach

                                    @if($post->tags->count() > 2)
                                        <span class="tag-item count">+{{ $post->tags->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif

                            <time class="post-date">
                                {{ $post->created_at->diffForHumans() }}
                            </time>
                        </div>

                        <a href="{{ route('post.show', $post->id) }}" class="post-title-link">
                            <h2 class="blog-post-title">
                                {{ Str::limit($post->title, 45) }}
                            </h2>
                        </a>

                        {{-- Інтерактивні елементи --}}
                        <div class="interactive-controls">
                            <div class="stat-item">
                                <i class="fa-solid fa-eye"></i>
                                <span class="views-count">{{ Number::abbreviate($post->views_count) }}</span>
                            </div>

                            @auth
                                @php
                                    $isLiked = auth()->user()->likedPosts()->where('post_id', $post->id)->exists();
                                    $isSaved = auth()->user()->savedPosts()->where('post_id', $post->id)->exists();
                                    $isReported = auth()->user()->reports()->where('reportable_id', $post->id)->where('reportable_type', Post::class)->exists();
                                @endphp

                                <form action="{{ route('post.like.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="interactive-btn">
                                        <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                    <span class="likes-count">{{ Number::abbreviate($post->likes_count) }}</span>
                                </form>

                                <form action="{{ route('post.save.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="interactive-btn">
                                        <i class="{{ $isSaved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                                    </button>
                                    <span class="saves-count">{{ Number::abbreviate($post->saves_count) }}</span>
                                </form>

                                <form action="{{ route('post.report.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="interactive-btn">
                                        <i class="{{ $isReported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                                    </button>
                                </form>
                            @endauth

                            @guest
                                <div class="stat-item clickable" onclick="showAuthModal();">
                                    <i class="fa-regular fa-heart"></i>
                                    <span class="likes-count">{{ Number::abbreviate($post->likes_count) }}</span>
                                </div>

                                <div class="stat-item clickable" onclick="showAuthModal();">
                                    <i class="fa-regular fa-bookmark"></i>
                                    <span class="saves-count">{{ Number::abbreviate($post->saves_count) }}</span>
                                </div>

                                <div class="stat-item clickable" onclick="showAuthModal();">
                                    <button type="button" class="interactive-btn">
                                        <i class="fa-regular fa-flag"></i>
                                    </button>
                                </div>
                            @endguest
                        </div>

                    </article>
                @endforeach
            </section>

            <div class="pagination-wrapper" data-aos="fade-up">
                {{ $posts->links('web::blade.pagination.bootstrap-4') }}
            </div>
        @else
            <div class="empty-state" data-aos="fade-up">
                There are no posts yet.
            </div>
        @endif

    </main>
@endsection
