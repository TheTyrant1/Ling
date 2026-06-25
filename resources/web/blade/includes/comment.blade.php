@php
    use App\Models\Comment;

    $level = $level ?? 1;
    $isLiked = auth()->check() && auth()->user()->likedComments()->where('comment_id', $comment->id)->exists();
    $isReported = auth()->check() && auth()->user()->reports()->where('reportable_id', $comment->id)->where('reportable_type', Comment::class)->exists();
@endphp

<div
    class="comment-node {{ $level === 1 ? '' : 'comment-node--reply' }} {{ $level > 1 && $loop->index >= 3 ? 'comment-node--hidden comment-node--hidden-reply' : '' }}">
    <div class="comment-node__core">
        <div class="comment-node__avatar-link">
            <a href="{{ route('user.show', $comment->user->id) }}">
                <img
                    src="{{ Storage::url($comment->user->profile_image) }}"
                    class="comment-node__avatar" alt="User profile">
            </a>
        </div>

        <div class="comment-node__content">
            <div class="comment-node__header">
                <a href="{{ route('user.show', $comment->user->id) }}"
                   class="comment-node__author">{{ $comment->user->name }}</a>

                @if(auth()->id() !== $comment->user->id)
                    @auth()
                        <form action="{{ route('comment.report.store', $comment->id) }}" method="post" title="Report" class="comment-node__report-form">
                            @csrf
                            <button type="submit" class="comment-node__action-btn">
                                <i class="{{ $isReported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                            </button>
                        </form>
                    @endauth

                    @guest
                        <button type="button" class="comment-node__action-btn" data-auth-trigger="true" title="Report">
                            <i class="fa-regular fa-flag"></i>
                        </button>
                    @endguest
                @endif

                @if($level > 1 && $comment->parent)
                    <span class="comment-node__recipient">
                        <i class="fa-solid fa-share fa-xs"></i> {{ $comment->parent->user->name }}
                    </span>
                @endif
                <span class="comment-node__time">{{ $comment->created_at->diffForHumans(null, true) }}</span>
            </div>

            <div class="comment-node__body">
                @if(mb_strlen($comment->message) > 150)
                    <div id="comment-short-{{ $comment->id }}"
                         class="comment-node__text-short">{{ Str::limit($comment->message, 150) }}</div>
                    <div id="comment-full-{{ $comment->id }}" class="comment-node__text-full comment-node--hidden">{{ $comment->message }}</div>
                    <div class="comment-node__read-more" data-comment-read-more="{{ $comment->id }}">
                        Read more
                    </div>
                @else
                    <div class="comment-node__text-short">{{ $comment->message }}</div>
                @endif
            </div>

            <div class="comment-node__actions">
                @auth
                    <form action="{{ route('comment.like.store', $comment->id) }}" method="POST" class="comment-node__report-form" title="Like">
                        @csrf
                        <button type="submit" class="comment-node__action-btn {{ $isLiked ? 'like-active' : '' }}" title="Like">
                            <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            <span>
                                {{ Number::abbreviate($comment->likes_count ?? 0) }}
                            </span>
                        </button>
                    </form>
                    @if(auth()->user()->status_id === 1)
                        <button data-comment-toggle-reply="reply-form-{{ $comment->id }}" class="comment-node__action-btn">
                            <i class="fa-regular fa-comment-dots"></i> Reply
                        </button>
                    @endif
                @else
                    <button type="button" class="comment-node__action-btn" data-auth-trigger="true">
                        <i class="fa-regular fa-heart"></i>
                        <span>{{ Number::abbreviate($comment->likes_count ?? 0) }}</span>
                    </button>

                    <button type="button" data-auth-trigger="true" class="comment-node__action-btn">
                        <i class="fa-regular fa-comment-dots"></i> Reply
                    </button>
                @endauth
            </div>

            @auth
                @if(auth()->user()->status_id === 1)
                    <div id="reply-form-{{ $comment->id }}" class="comment-node__reply-form comment-node--hidden">
                        <form action="{{ route('comment.store', $comment->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                            <div>
                                <textarea name="message"
                                          class="comment-node__textarea"
                                          rows="2"
                                          placeholder="Write a reply..."
                                          required></textarea>
                                @error('message')
                                <div class="comment-node__error">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="comment-node__form-actions">
                                <button type="button"
                                        class="comment-node__form-btn comment-node__form-btn--secondary"
                                        data-comment-toggle-reply="reply-form-{{ $comment->id }}">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="comment-node__form-btn comment-node__form-btn--primary">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    @if($level === 1 && $comment->replies->count() > 0)
        <button class="comment-node__toggle-replies"
                data-comment-toggle-replies="{{ $comment->id }}"
                id="view-btn-{{ $comment->id }}">
            —— View replies ({{ Number::abbreviate($comment->replies->count()) }})
        </button>
    @endif

    @if($comment->replies->count() > 0)
        <div class="comment-node__replies {{ $level === 1 ? 'comment-node--hidden' : '' }}" id="replies-group-{{ $comment->id }}">
            @foreach($comment->replies as $reply)
                @include('web::blade.includes.comment', ['comment' => $reply, 'level' => 2, 'post' => $post])
            @endforeach

            @if($level === 1 && $comment->replies->count() > 3)
                <button class="comment-node__load-more" id="load-more-{{ $comment->id }}"
                        data-comment-load-more="{{ $comment->id }}">
                    —— Show more
                </button>
            @endif
        </div>
    @endif
</div>
