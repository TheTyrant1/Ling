@php
    use App\Models\Comment;

    $level = $level ?? 1;
    $isLiked = auth()->check() && auth()->user()->likedComments()->where('comment_id', $comment->id)->exists();

    $isReported = auth()->check() && auth()->user()->reports()->where('reportable_id', $comment->id)->where('reportable_type', Comment::class)->exists()
@endphp

<style>
    .app-comment-node {
        position: relative;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .replies-container {
        margin-left: 40px;
        position: relative;
    }

    .replies-container::before {
        content: "";
        position: absolute;
        left: 23px;
        top: 5px;
        bottom: 20px;
        width: 2px;
        background: #f0f0f0;
        z-index: 1;
    }

    .reply-item .replies-container {
        margin-left: 0;
    }

    .reply-item .replies-container::before {
        display: none;
    }

    .comment-core {
        position: relative;
        z-index: 2;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        background: #fff;
    }

    .display-name {
        font-weight: 700;
        font-size: 14px;
        color: #161823;
    }

    .action-btn {
        color: #8a8b91;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
        transition: color 0.2s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .action-btn:hover,
    .toggle-replies-link:hover,
    .load-more-replies:hover,
    .read-more-text:hover,
    .like-active {
        color: #000 !important;
    }

    .read-more-text {
        color: #8a8b91;
        transition: color 0.2s ease;
    }

    .toggle-replies-link,
    .load-more-replies {
        color: #8a8b91;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        margin-left: 60px;
        display: block;
        margin-top: 5px;
        transition: color 0.2s ease;
        background: none;
        border: none;
        padding: 0;
    }

    .load-more-replies {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>

<div
    class="app-comment-node {{ $level === 1 ? 'mb-4' : 'reply-item mt-3' }} {{ $level > 1 && $loop->index >= 3 ? 'd-none hidden-reply' : '' }}">
    <div class="comment-core d-flex p-1">
        <div class="flex-shrink-0" style="cursor:pointer">
            <a href="{{ route('user.show', $comment->user->id) }}">
                <img
                    src="{{ asset('storage/' . $comment->user->profile_image) }}"
                    class="user-avatar" alt="User profile">
            </a>
        </div>

        <div class="flex-grow-1 ms-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('user.show', $comment->user->id) }}"
                   class="display-name text-decoration-none text-reset"
                   style="cursor:pointer;">{{ $comment->user->name }}</a>

                @if(auth()->id() !== $comment->user->id)
                    @auth()
                        <form action="{{ route('comment.report.store', $comment->id) }}" method="post" title="Report">
                            @csrf
                            <button type="submit" class="border-0 bg-transparent p-0 me-1 action-btn">
                                <i class="{{ $isReported ? 'fa-solid' : 'fa-regular' }} fa-flag"></i>
                            </button>
                        </form>
                    @endauth

                    @guest()
                        <div class="d-flex align-items-center" style="cursor:pointer"
                             onclick="showAuthModal();">
                            <button type="submit" class="border-0 bg-transparent p-0 me-1 action-btn">
                                <i class="fa-regular fa-flag"></i>
                            </button>
                        </div>
                    @endguest
                @endif

                @if($level > 1 && $comment->parent)
                    <span class="recipient-badge"
                          style="font-size: 12px; color: #8a8b91; background: #f1f1f2; padding: 1px 8px; border-radius: 4px;">
                        <i class="fa-solid fa-share fa-xs"></i> {{ $comment->parent->user->name }}
                    </span>
                @endif
                <span class="text-muted"
                      style="font-size: 11px;">{{ $comment->created_at->diffForHumans(null, true) }}</span>
            </div>

            <div class="comment-body mt-1" style="font-size: 15px; color: #161823;">
                @if(mb_strlen($comment->message) > 150)
                    <div id="comment-short-{{ $comment->id }}"
                         style="white-space: pre-wrap; word-break: break-word;">{{ Str::limit($comment->message, 150) }}</div>
                    <div id="comment-full-{{ $comment->id }}" class="d-none"
                         style="white-space: pre-wrap; word-break: break-word;">{{ $comment->message }}</div>
                    <div class="read-more-text mt-1"
                         style="cursor: pointer; font-size: 13px; font-weight: 600; display: inline-block; user-select: none;"
                         onclick="
                        document.getElementById('comment-short-{{ $comment->id }}').classList.toggle('d-none');
                        document.getElementById('comment-full-{{ $comment->id }}').classList.toggle('d-none');
                        this.innerText = this.innerText.trim() === 'Read more' ? 'Show less' : 'Read more';
                    ">Read more
                    </div>
                @else
                    <div style="white-space: pre-wrap; word-break: break-word;">{{ $comment->message }}</div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-4 mt-2">
                @auth
                    <form action="{{ route('comment.like.store', $comment->id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="action-btn {{ $isLiked ? 'like-active' : '' }}">
                            <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            <span>
                                {{ Number::abbreviate($comment->likes_count ?? 0) }}
                            </span>
                        </button>
                    </form>
                    @if(auth()->user()->status_id === 1)
                        <button onclick="toggleElement('reply-form-{{ $comment->id }}')" class="action-btn">
                            <i class="fa-regular fa-comment-dots"></i> Reply
                        </button>
                    @endif
                @else
                    <div class="action-btn" style="cursor: pointer;" onclick="showAuthModal()">
                        <i class="fa-regular fa-heart"></i>
                        <span>{{ Number::abbreviate($comment->likes_count ?? 0) }}</span>
                    </div>

                    <button onclick="showAuthModal()" class="action-btn">
                        <i class="fa-regular fa-comment-dots"></i> Reply
                    </button>
                @endauth
            </div>

            @auth
                @if(auth()->user()->status_id === 1)
                    <div id="reply-form-{{ $comment->id }}" class="mt-3 d-none animate__animated animate__fadeIn">
                        <form action="{{ route('comment.store', $comment->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                            <div class="mb-2">
                                <textarea name="message"
                                          class="form-control shadow-sm"
                                          rows="2"
                                          placeholder="Write a reply..."
                                          required
                                          style="font-size: 14px; border-radius: 16px; border: 1px solid #e1e1e1; padding: 12px 16px;"></textarea>
                                @error('message')
                                <div class="text-danger mt-1" style="font-size: 13px;">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button"
                                        class="btn btn-light btn-sm"
                                        style="font-size: 13px; font-weight: 600; border-radius: 20px; padding: 5px 15px;"
                                        onclick="toggleElement('reply-form-{{ $comment->id }}')">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="btn btn-dark btn-sm"
                                        style="font-size: 13px; font-weight: 600; border-radius: 20px; padding: 5px 20px; background-color: #000; border: none;">
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
        <button class="toggle-replies-link" onclick="toggleRepliesGroup({{ $comment->id }})"
                id="view-btn-{{ $comment->id }}">
            —— View replies ({{ Number::abbreviate($comment->replies->count()) }})
        </button>
    @endif

    @if($comment->replies->count() > 0)
        <div class="replies-container {{ $level === 1 ? 'd-none' : '' }}" id="replies-group-{{ $comment->id }}">
            @foreach($comment->replies as $reply)
                @include('web::blade.includes.comment', ['comment' => $reply, 'level' => 2, 'post' => $post])
            @endforeach

            @if($level === 1 && $comment->replies->count() > 3)
                <button class="load-more-replies" id="load-more-{{ $comment->id }}"
                        onclick="loadMoreReplies({{ $comment->id }})">
                    —— Show more
                </button>
            @endif
        </div>
    @endif
</div>

<script>
    function toggleElement(id) {
        const el = document.getElementById(id);
        if (el) el.classList.toggle('d-none');
    }

    function toggleRepliesGroup(id) {
        const group = document.getElementById('replies-group-' + id);
        const btn = document.getElementById('view-btn-' + id);

        if (group && btn) {
            if (group.classList.contains('d-none')) {
                group.classList.remove('d-none');
                btn.innerHTML = '—— Hide replies';
            } else {
                group.classList.add('d-none');
                const count = group.querySelectorAll(':scope > .reply-item').length;
                btn.innerHTML = `—— View replies (${count})`;
            }
        }
    }

    function loadMoreReplies(parentId) {
        const container = document.getElementById('replies-group-' + parentId);
        const hiddenReplies = container.querySelectorAll(':scope > .hidden-reply.d-none');

        for (let i = 0; i < 3; i++) {
            if (hiddenReplies[i]) {
                hiddenReplies[i].classList.remove('d-none');
            }
        }

        const remainingHidden = container.querySelectorAll(':scope > .hidden-reply.d-none').length;

        if (remainingHidden === 0) {
            const loadMoreBtn = document.getElementById('load-more-' + parentId);
            if (loadMoreBtn) loadMoreBtn.style.display = 'none';
        }
    }
</script>
