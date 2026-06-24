@extends('web::blade.layouts.web')

@php
    use App\Models\User;
    use Illuminate\Support\Number;
@endphp

@section('content')
    <main class="user-page">
        <div class="user-page__container">

            <div class="user-page__profile" data-aos="fade-up">
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="User image" class="user-page__avatar">
                <div class="user-page__name-wrapper">
                    <div class="user-page__name" title="{{ $user->name }}">{{ Str::limit($user->name, 15) }}</div>

                    @php
                        $isReportedUser = auth()->check() && auth()->user()->reports()->where('reportable_id', $user->id)->where('reportable_type', User::class)->exists();
                    @endphp

                    @if(!auth()->check() || auth()->id() !== $user->id)
                        @auth()
                            <form action="{{ route('user.report.store', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" title="Report" class="user-page__report-btn">
                                    <i class="{{ $isReportedUser ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                                </button>
                            </form>
                        @endauth

                        @guest()
                            <button title="Report" class="user-page__report-btn" data-auth-required>
                                <i class="fa-regular fa-flag"></i>
                            </button>
                        @endguest
                    @endif
                </div>

                <div class="user-page__stats">
                    <div class="user-page__stat-item">
                        <div class="user-page__stat-number">{{ $user->followers()->count() }}</div>
                        <div class="user-page__stat-label">Followers</div>
                    </div>
                </div>

                @auth
                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('user.follow.store', $user->id) }}" method="post">
                            @csrf

                            @if(auth()->user()->isFollowing($user))
                                <button class="user-page__follow-btn user-page__follow-btn--secondary">
                                    Unfollow
                                </button>
                            @else
                                <button class="user-page__follow-btn user-page__follow-btn--primary">
                                    Follow
                                </button>
                            @endif
                        </form>
                    @endif
                @endauth

                @guest()
                    <button class="user-page__follow-btn user-page__follow-btn--primary" data-auth-required>Follow</button>
                @endguest

            </div>

            <div class="user-page__posts">
                @if($posts->count() > 2)
                    @include('web::blade.includes.sort-select', [
                        'action' => route('user.show', $user->id),
                        'selected' => $sort ?? 'latest',
                        'formClass' => 'user-page__filter',
                    ])
                @endif

                @if($posts->count())
                    <section class="posts-grid">
                        @foreach($posts as $post)
                            <article class="post-card">
                                <div class="post-card__media">
                                    <a href="{{ route('user.show', $post->user->id) }}" class="post-card__author">
                                        <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="User image">
                                        <span title="{{ $post->user->name }}">{{ Str::limit($post->user->name, 10) }}</span>
                                    </a>
                                    <a href="{{ route('post.show', $post->id) }}" class="post-card__image-link">
                                        <img src="{{ asset('storage/' . $post->preview_image) }}" alt="{{ $post->title }}" class="post-card__image">
                                    </a>
                                </div>

                                <div class="post-card__meta">
                                    @if($post->tags->count())
                                        <div class="post-card__tags">
                                            @foreach($post->tags->take(2) as $tag)
                                                <a href="{{ route('tag.index', $tag->id) }}" class="post-card__tag">#{{ Str::limit($tag->title, 10) }}</a>
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

                                <div class="post-card__controls">
                                    <div class="post-card__stat">
                                        <i class="fa-solid fa-eye"></i>
                                        <span class="views-count">{{ Number::abbreviate($post->views_count) }}</span>
                                    </div>

                                    @auth
                                        <form action="{{ route('post.like.store', $post->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="post-card__action-btn">
                                                <i class="{{ $post->is_liked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                            </button>
                                            <span class="likes-count">{{ Number::abbreviate($post->likes_count) }}</span>
                                        </form>

                                        <form action="{{ route('post.save.store', $post->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="post-card__action-btn">
                                                <i class="{{ $post->is_saved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                                            </button>
                                            <span class="saves-count">{{ Number::abbreviate($post->saves_count) }}</span>
                                        </form>

                                        <form action="{{ route('post.report.store', $post->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="post-card__action-btn">
                                                <i class="{{ $post->is_reported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
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

                    <div class="pagination-wrapper">
                        {{ $posts->links('web::blade.pagination.pagination') }}
                    </div>
                @else
                    @if(auth()->id() === $user->id)
                        <div class="empty-state">
                            You haven’t published any posts yet.
                        </div>
                    @else
                        <div class="empty-state">
                            This user hasn’t published any posts yet.
                        </div>
                    @endif
                @endif

            </div>

        </div>
    </main>
@endsection
