@extends('web::blade.layouts.web')

@php
    use App\Models\User;
    use App\Models\Post;
    use Illuminate\Support\Number;
@endphp

@section('content')
    <style>
        .user-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
            text-align: center;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .user-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .user-username {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .user-bio {
            font-size: 14px;
            color: #666;
            max-width: 600px;
            margin-bottom: 20px;
        }

        .user-stats {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }

        .user-stats div {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-stats .stat-number {
            font-weight: bold;
            font-size: 18px;
        }

        .user-stats .stat-label {
            font-size: 12px;
            color: #777;
        }

        .user-posts {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .blog-post-thumbnail-wrapper {
            width: 100%;
            height: 180px;
            overflow: hidden;
            border-radius: 12px;
            position: relative;
        }

        .blog-post-thumbnail-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
            display: block;
        }

        .blog-post:hover .blog-post-thumbnail-wrapper img {
            transform: scale(1.05);
        }

        .blog-post-title,
        .tag-item,
        .post-date,
        .views-count,
        .likes-count,
        .saves-count,
        .blog-post i {
            color: #444 !important;
            transition: color 0.2s ease-in-out;
            text-decoration: none;
        }

        .blog-post:hover .blog-post-title,
        .blog-post:hover .tag-item,
        .blog-post:hover .post-date,
        .blog-post:hover .views-count,
        .blog-post:hover .likes-count,
        .blog-post:hover .saves-count,
        .blog-post:hover i {
            color: #000 !important;
        }

        .interactive-controls {
            position: relative;
            z-index: 10;
        }

        .blog-post-permalink {
            text-decoration: none;
        }

        .blog-post-thumbnail-wrapper {
            width: 100%;
            height: 240px;
            overflow: hidden;
            border-radius: 16px;
            position: relative;
        }

        .blog-post-thumbnail-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
            display: block;
        }

        .blog-post:hover .blog-post-thumbnail-wrapper img {
            transform: scale(1.05);
        }

        /* === AUTHOR BADGE === */
        .author-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            align-items: center;
            gap: 8px;

            padding: 6px 10px;
            border-radius: 999px;

            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(6px);

            color: #fff;
            font-size: 13px;
            z-index: 5;
        }

        .author-badge img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 768px) {
            .blog-post-thumbnail-wrapper {
                height: 200px;
            }
        }

        .fa-eye, .fa-heart, .fa-bookmark {
            font-size: 18px;
            line-height: 1;
        }
    </style>

    <main class="blog" style="min-height: 100vh;">
        <div class="container py-5">

            <!-- User Info -->
            <div class="user-profile" data-aos="fade-up">
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="User image" class="user-avatar">
                <div class="d-flex align-items-center" style="gap: 10px">
                    <div class="user-name" title="{{ $user->name }}">{{ Str::limit($user->name, 15) }}</div>

                    @php
                        $isReportedUser = auth()->check() && auth()->user()->reports()->where('reportable_id', $user->id)->where('reportable_type', User::class)->exists();
                    @endphp

                    @if(!auth()->check() || auth()->id() !== $user->id)
                        @auth()
                            <form action="{{ route('user.report.store', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" title="Report" class="border-0 bg-transparent p-0 me-1 report-btn">
                                    <i class="{{ $isReportedUser ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                                </button>
                            </form>
                        @endauth

                        @guest()
                            <button title="Report" class="border-0 bg-transparent p-0 me-1 report-btn"
                                    onclick="showAuthModal();">
                                <i class="fa-regular fa-flag"></i>
                            </button>
                        @endguest
                    @endif
                </div>

                <!-- User Stats -->
                <div class="user-stats">
                    <div>
                        <div class="stat-number">{{ $user->followers()->count() }}</div>
                        <div class="stat-label">Followers</div>
                    </div>
                </div>
                @auth
                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('user.follow.store', $user->id) }}" method="post">
                            @csrf

                            @if(auth()->user()->isFollowing($user))
                                <button class="btn btn-light border">
                                    Unfollow
                                </button>
                            @else
                                <button class="btn btn-dark">
                                    Follow
                                </button>
                            @endif

                        </form>
                    @endif
                @endauth

                @guest()
                    <button class="btn btn-dark" onclick="showAuthModal();">Follow</button>
                @endguest

            </div>

            <main class="main__container">
                @if($posts->count() > 2)
                    <form method="GET" action="{{ route('user.show', $user->id) }}" class="d-flex justify-content-end mb-4"
                          data-aos="fade-up">
                        <select name="sort" class="form-select" style="width:auto; min-width:140px;"
                                onchange="this.form.submit()">
                            <option value="latest" {{ (isset($sort) && $sort == 'latest') ? 'selected' : '' }}>
                                Latest
                            </option>

                            <option value="popular" {{ (isset($sort) && $sort == 'popular') ? 'selected' : '' }}>
                                Popular
                            </option>
                        </select>
                    </form>
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
                        This user hasn’t published any posts yet.
                    </div>
                @endif

            </main>

        </div>
    </main>
@endsection
