@extends('web::blade.layouts.web')

@php
    use Illuminate\Support\Number;
@endphp

@section('content')
    <main class="main__container">
        @if($posts->count() > 1)
            <div class="main__filter-bar">
                <form method="GET" action="{{ route('post.index') }}">
                    <div class="sort-select">
                        <select name="sort" class="sort-select__native" aria-hidden="true" tabindex="-1">
                            <option value="latest" @selected(request('sort', 'latest') == 'latest')>Latest</option>
                            <option value="popular" @selected(request('sort') == 'popular')>Popular</option>
                        </select>

                        <button type="button"
                                class="sort-select__trigger"
                                aria-haspopup="listbox"
                                aria-expanded="false">
                            <span class="sort-select__text">Latest</span>
                            <i class="fa-solid fa-chevron-down sort-select__icon" aria-hidden="true"></i>
                        </button>

                        <ul class="sort-select__menu" role="listbox">
                            <li class="sort-select__option @if(request('sort', 'latest') == 'latest') sort-select__option--selected @endif"
                                role="option"
                                data-value="latest"
                                aria-selected="{{ request('sort', 'latest') == 'latest' ? 'true' : 'false' }}">
                                Latest
                            </li>
                            <li class="sort-select__option @if(request('sort') == 'popular') sort-select__option--selected @endif"
                                role="option"
                                data-value="popular"
                                aria-selected="{{ request('sort') == 'popular' ? 'true' : 'false' }}">
                                Popular
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        @endif

        @if($posts->count())
            <section class="main__grid">
                @foreach($posts as $post)
                    <article class="main__post">
                        <div class="main__post-media">
                            <a href="{{ route('user.show', $post->user->id) }}" class="author-badge">
                                <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="User image">
                                <span title="{{ $post->user->name }}">{{ Str::limit($post->user->name, 10) }}</span>
                            </a>
                            <a href="{{ route('post.show', $post->id) }}">
                                <img src="{{ asset('storage/' . $post->preview_image) }}" alt="{{ $post->title }}" class="post-preview-img">
                            </a>
                        </div>

                        <div class="main__post-meta">
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
                            <h2 class="post-title">
                                {{ Str::limit($post->title, 45) }}
                            </h2>
                        </a>

                        <div class="interactive-controls">
                            <div class="stat-item">
                                <i class="fa-solid fa-eye"></i>
                                <span class="views-count">{{ Number::abbreviate($post->views_count) }}</span>
                            </div>

                            @auth
                                <form action="{{ route('post.like.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="interactive-btn">
                                        <i class="{{ $post->is_liked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                    <span class="likes-count">{{ Number::abbreviate($post->likes_count) }}</span>
                                </form>

                                <form action="{{ route('post.save.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="interactive-btn">
                                        <i class="{{ $post->is_saved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                                    </button>
                                    <span class="saves-count">{{ Number::abbreviate($post->saves_count) }}</span>
                                </form>

                                <form action="{{ route('post.report.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="interactive-btn">
                                        <i class="{{ $post->is_reported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                                    </button>
                                </form>
                            @endauth

                            @guest
                                <div class="stat-item clickable" onclick="showAuthModal();">
                                    <button type="button" class="interactive-btn">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                    <span class="likes-count">{{ Number::abbreviate($post->likes_count) }}</span>
                                </div>

                                <div class="stat-item clickable" onclick="showAuthModal();">
                                    <button type="button" class="interactive-btn">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
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

            <div class="overflow-x-auto pagination-wrapper">
                {{ $posts->links('web::blade.pagination.bootstrap-4') }}
            </div>
        @else
            <div class="empty-state">
                There are no posts yet.
            </div>
        @endif

    </main>
@endsection
