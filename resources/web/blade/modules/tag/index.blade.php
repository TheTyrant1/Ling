@extends('web::blade.layouts.web')

@php
    use App\Models\Post;
    use Illuminate\Support\Number;
@endphp

@section('content')
    <main class="tag-page">

        <div class="tag-page__header" data-aos="fade-up">
            <h1 class="tag-page__title">#{{ $tag->title }}</h1>

            @if($posts->count() > 1)
                <p class="tag-page__subtitle">
                    Posts: {{ $tag->posts->count() }}
                </p>
            @endif
        </div>

        {{-- Sorting Block --}}
        @if($posts->count() > 1)
            <div class="tag-page__filter-bar" data-aos="fade-up">
                @include('web::blade.includes.sort-select', [
                    'action' => route('tag.index', $tag->id),
                    'selected' => request('sort', 'latest'),
                ])
            </div>
        @endif

        {{-- Posts Grid --}}
        @if($posts->count())
            <section class="posts-grid">
                @foreach($posts as $post)
                    <article class="post-card" data-aos="fade-up">

                        {{-- Image and Author --}}
                        <div class="post-card__media">
                            <a href="{{ route('user.show', $post->user->id) }}" class="post-card__author">
                                <img src="{{ Storage::url($post->user->profile_image) }}" alt="User image">
                                <span title="{{ $post->user->name }}">{{ Str::limit($post->user->name, 10) }}</span>
                            </a>
                            <a href="{{ route('post.show', $post->id) }}" class="post-card__image-link">
                                <img src="{{ Storage::url($post->preview_image) }}" alt="{{ $post->title }}" class="post-card__image">
                            </a>
                        </div>

                        {{-- Metadata --}}
                        <div class="post-card__meta">
                            @if($post->tags->count())
                                <div class="post-card__tags">
                                    @foreach($post->tags->take(2) as $t)
                                        <a href="{{ route('tag.index', $t->id) }}" class="post-card__tag">#{{ Str::limit($t->title, 10) }}</a>
                                    @endforeach

                                    @if($post->tags->count() > 2)
                                        <span class="post-card__tag count">+{{ $post->tags->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif

                            <time class="post-card__date">
                                {{ $post->created_at->diffForHumans() }}
                            </time>
                        </div>

                        <a href="{{ route('post.show', $post->id) }}" class="post-card__title-link">
                            <h2 class="post-card__title">
                                {{ Str::limit($post->title, 45) }}
                            </h2>
                        </a>

                        {{-- Interactive controls --}}
                        <div class="post-card__controls">
                            <div class="post-card__stat">
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
                                    <button type="submit" class="post-card__action-btn">
                                        <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                    <span class="likes-count">{{ Number::abbreviate($post->likes_count) }}</span>
                                </form>

                                <form action="{{ route('post.save.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="post-card__action-btn">
                                        <i class="{{ $isSaved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                                    </button>
                                    <span class="saves-count">{{ Number::abbreviate($post->saves_count) }}</span>
                                </form>

                                <form action="{{ route('post.report.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="post-card__action-btn">
                                        <i class="{{ $isReported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                                    </button>
                                </form>
                            @endauth

                            @guest
                                <div class="post-card__stat post-card__stat--clickable" data-auth-required>
                                    <button type="button" class="post-card__action-btn">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                    <span class="likes-count">{{ Number::abbreviate($post->likes_count) }}</span>
                                </div>

                                <div class="post-card__stat post-card__stat--clickable" data-auth-required>
                                    <button type="button" class="post-card__action-btn">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </button>
                                    <span class="saves-count">{{ Number::abbreviate($post->saves_count) }}</span>
                                </div>

                                <div class="post-card__stat post-card__stat--clickable" data-auth-required>
                                    <button type="button" class="post-card__action-btn">
                                        <i class="fa-regular fa-flag"></i>
                                    </button>
                                </div>
                            @endguest
                        </div>

                    </article>
                @endforeach
            </section>

            <div class="pagination-wrapper" data-aos="fade-up">
                {{ $posts->links('web::blade.pagination.pagination') }}
            </div>
        @else
            <div class="empty-state" data-aos="fade-up">
                There are no posts yet.
            </div>
        @endif

    </main>
@endsection
