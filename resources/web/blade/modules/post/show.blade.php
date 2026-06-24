@extends('web::blade.layouts.web')

@php
    use App\Models\Post;
    use Illuminate\Support\Number;
@endphp

@section('content')
    <main class="post-show">
        <div class="post-show__container">
            <section class="post-show__header" data-aos="fade-up">
                <h1 class="post-show__title">
                    {{ $post->title }}
                </h1>
                <a href="{{ route('user.show', $post->user->id) }}" class="post-show__author-link">
                    <div class="post-show__author-badge">
                        <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="User image">
                        <span title="{{ $post->user->name }}">
                            {{ Str::limit($post->user->name, 17) }}
                        </span>
                    </div>
                </a>
                <p class="post-show__date">
                    @if($post->user_updated_at?->gt($post->created_at))
                        Edited: {{ $post->user_updated_at->format('d M Y • H:i') }}
                    @else
                        {{ $post->created_at->format('d M Y • H:i') }}
                    @endif

                    • {{ Number::abbreviate($post->comments->count()) }} Comments
                </p>
                @if($post->tags->isNotEmpty())
                    <div class="post-show__tags">
                        @foreach($post->tags as $index => $tag)
                            <a href="{{ route('tag.index', $tag->id) }}"
                               class="post-show__tag {{ $index >= 3 ? 'post-show__tag--hidden' : '' }}">
                                #{{ $tag->title }}
                            </a>
                        @endforeach
                        @if($post->tags->count() > 3)
                            <button type="button" class="post-show__tag-toggle" data-post-tags-toggle>
                                Show more
                            </button>
                        @endif
                    </div>
                @endif

                <div class="post-show__image-wrapper">
                    <img src="{{ asset('storage/' . $post->main_image) }}" class="post-show__image"
                         alt="{{ $post->title }}">
                </div>
            </section>

            <section class="post-show__body" data-aos="fade-up">
                <div class="post-show__content">{!! $post->content !!}</div>

                <div class="post-show__controls" data-aos="fade-up">

                    <div class="post-show__stat-item">
                        <i class="fa-solid fa-eye"></i>
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
                            <button type="submit" class="post-show__interactive-btn">
                                <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
                            <span class="likes-count">
                                {{ Number::abbreviate($post->likes_count) }}
                            </span>
                        </form>

                        <form action="{{ route('post.save.store', $post->id) }}" method="post" title="Save">
                            @csrf
                            <button type="submit" class="post-show__interactive-btn">
                                <i class="{{ $isSaved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                            </button>
                            <span class="saves-count">
                                {{ Number::abbreviate($post->saves_count) }}
                            </span>
                        </form>

                        <form action="{{ route('post.report.store', $post->id) }}" method="post" title="Report">
                            @csrf
                            <button type="submit" class="post-show__interactive-btn">
                                <i class="{{ $isReported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                            </button>
                        </form>
                    @endauth

                    @guest()
                        <div class="post-show__stat-item post-show__stat-item--clickable" data-auth-required>
                            <button type="button" class="post-show__interactive-btn">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <span class="likes-count">
                                {{ Number::abbreviate($post->likes_count) }}
                            </span>
                        </div>

                        <div class="post-show__stat-item post-show__stat-item--clickable" data-auth-required>
                            <button type="button" class="post-show__interactive-btn">
                                <i class="fa-regular fa-bookmark"></i>
                            </button>
                            <span class="saves-count">
                                {{ Number::abbreviate($post->saves_count) }}
                            </span>
                        </div>

                        <div class="post-show__stat-item post-show__stat-item--clickable" data-auth-required>
                            <button type="button" class="post-show__interactive-btn">
                                <i class="fa-regular fa-flag"></i>
                            </button>
                        </div>
                    @endguest
                </div>
                <hr class="post-show__divider" data-aos="fade-up">
            </section>

            @if($relatedPosts->count() > 0)
                <section class="post-show__related" data-aos="fade-up">
                    <h2 class="post-show__related-title">Related Posts</h2>
                    <div class="post-show__related-grid">
                        @foreach($relatedPosts as $relatedPost)
                            <a href="{{ route('post.show', $relatedPost->id) }}" class="post-show__related-card">
                                <div class="post-show__related-img">
                                    <img src="{{ asset('storage/' . $relatedPost->preview_image) }}"
                                         alt="related post">
                                </div>

                                <h5 class="post-show__related-card-title">{{ Str::limit($relatedPost->title, 35) }}</h5>
                            </a>
                        @endforeach
                    </div>
                    <hr class="post-show__divider post-show__divider--margin-top" data-aos="fade-up">
                </section>
            @endif

            @auth()
                @if(auth()->user()->status_id === 1)
                    <section class="post-show__comment-form" data-aos="fade-up">
                        <h2 class="post-show__section-title">Add a comment</h2>
                        <form action="{{ route('comment.store', $post->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <textarea name="message" class="post-show__textarea" rows="3" required
                                      placeholder="Write your message here..."></textarea>
                            @error('message')
                            <div class="post-show__error">
                                {{ $message }}
                            </div>
                            @enderror
                            <button type="submit" class="post-show__submit-btn">Send</button>
                        </form>
                    </section>
                @endif
            @else
                <section class="post-show__comment-form" data-aos="fade-up">
                    <div class="post-show__auth-notice">
                        Please
                        <a href="{{ route('login') }}">login</a>
                        or
                        <a href="{{ route('register') }}">register</a>
                        to leave a comment.
                    </div>
                </section>
            @endauth

            <section class="post-show__comments" data-aos="fade-up">
                <div class="post-show__comments-header">
                    <h2 class="post-show__section-title">Comments
                        ({{ Number::abbreviate($post->comments->count()) }})</h2>

                    @if($comments->count() > 1)
                        @include('web::blade.includes.sort-select', [
                            'action' => route('post.show', $post->id),
                            'selected' => $sort ?? 'latest',
                            'class' => 'sort-select--comments',
                        ])
                    @endif
                </div>

                @if($comments->count() > 0)
                    @foreach($comments as $comment)
                        @include('web::blade.includes.comment', ['comment' => $comment, 'level' => 1])
                    @endforeach
                @else
                    <p class="post-show__no-comments">No comments yet.</p>
                @endif

                <div class="post-show__pagination">
                    {{ $comments->links('web::blade.pagination.pagination') }}
                </div>
            </section>
        </div>
    </main>
@endsection
