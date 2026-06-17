@extends('web::blade.layouts.web')

@php
    use App\Models\Post;
    use Illuminate\Support\Number;
@endphp

@section('content')
    <style>
        .reply-btn, .hide-replies-btn, .load-more-replies {
            color: #6c757d !important;
            font-size: 0.75rem !important;
            text-decoration: none !important;
            border: none !important;
            background: none !important;
            box-shadow: none !important;
            outline: none !important;
            transition: color 0.2s ease-in-out;
        }

        .load-more-replies {
            font-size: 0.8rem !important;
        }

        .reply-btn:hover,
        .hide-replies-btn:hover,
        .load-more-replies:hover {
            color: #000000 !important;
        }

        .line-decorator {
            display: inline-block;
            width: 20px;
            height: 1px;
            background: #ccc;
            margin-right: 5px;
            vertical-align: middle;
            transition: background-color 0.2s ease-in-out;
        }

        .load-more-replies:hover .line-decorator {
            background-color: #000000 !important;
        }

        .main-post-image {
            border-radius: 20px;
            height: 450px;
            object-fit: cover;
        }

        .related-post-img-wrapper {
            border-radius: 20px;
            overflow: hidden;
            height: 150px;
            margin-bottom: 15px;
        }

        @media (max-width: 575.98px) {
            .main-post-image {
                height: 220px;
                border-radius: 14px;
            }

            .related-post-img-wrapper {
                height: 120px;
            }
        }

        @media (min-width: 576px) and (max-width: 991.98px) {
            .main-post-image {
                height: 300px;
            }
        }

        .related-post-img-wrapper img {
            transition: transform 0.3s ease-in-out;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .related-post-card:hover .related-post-img-wrapper img {
            transform: scale(1.075);
        }

        .btn-modern {
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            background: #4e4e4e;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-modern:hover {
            background: #404040;
        }

        /* Базовий колір для тексту (сірий) */
        .related-post-card .post-title,
        .related-post-card .post-category {
            color: #444 !important;
            transition: color 0.3s ease;
        }

        /* При ховері на всю картку — текст стає чорним */
        .related-post-card:hover .post-title,
        .related-post-card:hover .post-category {
            color: #000 !important;
        }

        /* Прибираємо стандартне підкреслення посилання */
        .related-post-card {
            text-decoration: none !important;
        }

        .tag-toggle-btn {
            color: #8a8b91 !important;
            background-color: transparent !important;
            transition: all 0.2s ease;
        }

        .tag-toggle-btn:hover {
            color: #000 !important;
            border-color: #000 !important;
        }

        /* Контейнер баджа */
        .author-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            color: #6c757d; /* Початковий сірий колір */
            font-size: 15px;
            cursor: pointer;

            /* Плавність для всього: фону, тіні, відступів */
            transition: all 0.3s ease-in-out;
        }

        /* Окремо для тексту всередині, щоб колір змінювався плавно */
        .author-badge span {
            transition: color 0.3s ease-in-out;
        }

        .author-link {
            text-decoration: none;
            display: inline-block;
        }

        .author-link:hover,
        .author-link:focus {
            text-decoration: none !important;
            outline: none;
        }

        .author-link:hover .author-badge {
            color: #161823;
            background-color: rgba(0, 0, 0, 0.04);
        }

        .author-link:hover .author-badge span {
            color: #161823 !important;
        }

        .author-badge img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .author-link:hover .author-badge img {
            transform: scale(1.05);
        }
    </style>

    <main class="blog-post app-main">
        <div class="container">
            <section class="post-header mt-5" data-aos="fade-up">
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h1 class="page-title">
                            {{ $post->title }}
                        </h1>
                        <a href="{{ route('user.show', $post->user->id) }}" class="author-link">
                            <div class="d-flex justify-content-center">
                                <div class="author-badge">
                                    <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="User image">
                                    <span title="{{ $post->user->name }}">
                                        {{ Str::limit($post->user->name, 17) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        <p class="text-muted mt-3">

                            @if($post->user_updated_at?->gt($post->created_at))
                                Edited: {{ $post->user_updated_at->format('d M Y • H:i') }}
                            @else
                                {{ $post->created_at->format('d M Y • H:i') }}
                            @endif

                            • {{ Number::abbreviate($post->comments->count()) }} Comments
                        </p>
                        @if($post->tags->isNotEmpty())
                            <div class="d-flex justify-content-center flex-wrap gap-2 mt-3 mx-auto"
                                 style="max-width: 850px; padding: 5px;">
                                @foreach($post->tags as $index => $tag)
                                    <a href="{{ route('tag.index', $tag->id) }}"
                                       class="badge rounded-pill bg-light text-muted border tag-item {{ $index >= 3 ? 'd-none' : '' }}"
                                       style="font-weight: 500;">
                                        #{{ $tag->title }}
                                    </a>
                                @endforeach
                                @if($post->tags->count() > 3)
                                    <span class="badge rounded-pill border tag-toggle-btn"
                                          style="font-weight: 500; cursor: pointer; user-select: none;" onclick="
                                        const tags = this.parentNode.querySelectorAll('.tag-item');
                                        let isHidden = false;
                                        tags.forEach((tag, idx) => {
                                            if (idx >= 3) {
                                                tag.classList.toggle('d-none');
                                                if (tag.classList.contains('d-none')) {
                                                    isHidden = true;
                                                }
                                            }
                                        });
                                        this.innerText = isHidden ? 'Show more' : 'Show less';
                                    ">Show more</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-12 text-center">
                        <img src="{{ asset('storage/' . $post->main_image) }}" class="img-fluid main-post-image"
                             style="width: 100%;">
                    </div>
                </div>
            </section>

            <section class="post-body mt-5">
                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        <div class="post-content mb-4" data-aos="fade-up">{!! $post->content !!}</div>

                        <div class="d-flex align-items-center gap-3 mb-4" style="position: relative; z-index: 2;"
                             data-aos="fade-up">

                            <div>
                                <i class="fa-solid fa-eye me-1"></i>
                                <span class="views-count">
                                    {{ Number::abbreviate($post->views_count) }}
                                </span>
                            </div>

                            @php
                                $isLiked = auth()->check() && auth()->user()->likedPosts()->where('post_id', $post->id)->exists();
                                $isSaved = auth()->check() && auth()->user()->savedPosts()->where('post_id', $post->id)->exists();
                                $isReported = auth()->check() && auth()->user()->reports()->where('reportable_id', $post->id)->where('reportable_type', Post::class)->exists();
                            @endphp

                            @auth()
                                <form action="{{ route('post.like.store', $post->id) }}" method="post" title="Like">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 me-1 like-btn">
                                        <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                    <span class="likes-count">
                                        {{ Number::abbreviate($post->likes_count) }}
                                    </span>
                                </form>

                                <form action="{{ route('post.save.store', $post->id) }}" method="post" title="Save">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 me-1 bookmark-btn">
                                        <i class="{{ $isSaved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                                    </button>
                                    <span class="saves-count">
                                        {{ Number::abbreviate($post->saves_count) }}
                                    </span>
                                </form>

                                <form action="{{ route('post.report.store', $post->id) }}" method="post" title="Report">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 me-1 report-btn">
                                        <i class="{{ $isReported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                                    </button>
                                </form>
                            @endauth

                            @guest()
                                <div class="d-flex align-items-center" style="cursor:pointer"
                                     onclick="showAuthModal();">
                                    <i class="fa-regular fa-heart me-1"></i>
                                    <span class="likes-count">
                                        {{ Number::abbreviate($post->likes_count) }}
                                    </span>
                                </div>

                                <div class="d-flex align-items-center" style="cursor:pointer"
                                     onclick="showAuthModal();">
                                    <i class="fa-regular fa-bookmark me-1"></i>
                                    <span class="saves-count">
                                        {{ Number::abbreviate($post->saves_count) }}
                                    </span>
                                </div>

                                <div class="d-flex align-items-center" style="cursor:pointer"
                                     onclick="showAuthModal();">
                                    <button type="submit" class="border-0 bg-transparent p-0 me-1 report-btn">
                                        <i class="fa-regular fa-flag"></i>
                                    </button>
                                </div>
                            @endguest
                        </div>
                        <hr class="section-divider" data-aos="fade-up">
                    </div>
                </div>
            </section>

            @if($relatedPosts->count() > 0)
                <section class="related-posts" data-aos="fade-up">
                    <div class="row">
                        <div class="col-lg-9 mx-auto">
                            <h2 class="h4 mb-4 font-weight-bold">Related Posts</h2>
                            <div class="row">
                                @foreach($relatedPosts as $relatedPost)
                                    <div class="col-md-4 mb-4">
                                        <a href="{{ route('post.show', $relatedPost->id) }}" class="related-post-card">
                                            <div class="related-post-img-wrapper">
                                                <img src="{{ asset('storage/' . $relatedPost->preview_image) }}"
                                                     alt="related post">
                                            </div>

                                            <h5 class="post-title h6 font-weight-bold">{{ Str::limit($relatedPost->title, 35) }}</h5>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="section-divider" data-aos="fade-up">
                        </div>
                    </div>
                </section>
            @endif

            @auth()
                @if(auth()->user()->status_id === 1)
                    <section class="comment-form mt-4 pb-4" data-aos="fade-up">
                        <div class="row">
                            <div class="col-lg-9 mx-auto">
                                <h2 class="h4 mb-3 font-weight-bold">Add a comment</h2>
                                <form action="{{ route('comment.store', $post->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <textarea name="message" class="form-control mb-3" rows="3" required
                                              placeholder="Write your message here..."></textarea>
                                    @error('message')
                                    <div class="text-danger mt-1 mb-4" style="font-size: 13px;">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <button type="submit" class="btn-modern">Send</button>
                                </form>
                            </div>
                        </div>
                    </section>
                @endif
            @else
                <section class="comment-form mt-4 pb-4" data-aos="fade-up">
                    <div class="row">
                        <div class="col-lg-9 mx-auto">
                            <div class="alert alert-light border text-muted">
                                Please
                                <a href="{{ route('login') }}" class="text-primary font-weight-bold">login</a>
                                or
                                <a href="{{ route('register') }}" class="text-primary font-weight-bold">register</a>
                                to leave a comment.
                            </div>
                        </div>
                    </div>
                </section>
            @endauth

            <section class="comment-list mt-4 pb-4" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        <h2 class="h4 mb-4 font-weight-bold">Comments
                            ({{ Number::abbreviate($post->comments->count()) }})</h2>
                        @if($comments->count() > 1)
                            <form method="GET" action="{{ route('post.show', $post->id) }}"
                                  class="d-flex justify-content-start mb-4">
                                <div class="sort-select sort-select--comments">
                                    <select name="sort" class="sort-select__native" aria-hidden="true" tabindex="-1">
                                        <option value="latest" @selected(($sort ?? 'latest') == 'latest')>Latest</option>
                                        <option value="popular" @selected(($sort ?? '') == 'popular')>Popular</option>
                                    </select>

                                    <button type="button"
                                            class="sort-select__trigger"
                                            aria-haspopup="listbox"
                                            aria-expanded="false">
                                        <span class="sort-select__text">Latest</span>
                                        <i class="fa-solid fa-chevron-down sort-select__icon" aria-hidden="true"></i>
                                    </button>

                                    <ul class="sort-select__menu" role="listbox">
                                        <li class="sort-select__option @if(($sort ?? 'latest') == 'latest') sort-select__option--selected @endif"
                                            role="option"
                                            data-value="latest"
                                            aria-selected="{{ ($sort ?? 'latest') == 'latest' ? 'true' : 'false' }}">
                                            Latest
                                        </li>
                                        <li class="sort-select__option @if(($sort ?? '') == 'popular') sort-select__option--selected @endif"
                                            role="option"
                                            data-value="popular"
                                            aria-selected="{{ ($sort ?? '') == 'popular' ? 'true' : 'false' }}">
                                            Popular
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        @endif
                        @if($comments->count() > 0)
                            @foreach($comments as $comment)
                                @include('web::blade.includes.comment', ['comment' => $comment, 'level' => 1])
                            @endforeach
                        @else
                            <p class="text-muted italic">No comments yet.</p>
                        @endif

                        <div class="mt-4 d-flex justify-content-center">
                            {{ $comments->links('web::blade.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
