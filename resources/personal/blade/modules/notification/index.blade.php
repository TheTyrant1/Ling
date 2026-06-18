@extends('personal::blade.layouts.personal')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Notifications</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12 col-md-4 col-lg-2">
                        @if(auth()->user()->notifications()->exists())
                            <form method="GET" action="{{ route('personal.notification.index') }}">
                                <select name="type" class="form-select" onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="follow" {{ request('type') == 'follow' ? 'selected' : '' }}>Follows
                                    </option>
                                    <option value="like" {{ request('type') == 'like' ? 'selected' : '' }}>Likes
                                    </option>
                                    <option value="save" {{ request('type') == 'save' ? 'selected' : '' }}>Saves
                                    </option>
                                    <option value="comment" {{ request('type') == 'comment' ? 'selected' : '' }}>
                                        Comments
                                    </option>
                                    <option value="report" {{ request('type') == 'report' ? 'selected' : '' }}>Reports
                                    </option>
                                </select>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-10 col-lg-10">
                        @if($notifications->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">User / System</th>
                                            <th class="px-4 border-0">Post</th>
                                            <th class="px-4 border-0">Comment</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($notifications as $notification)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        @if($notification->fromUser)
                                                            <img
                                                                src="{{ asset('storage/' . $notification->fromUser->profile_image) }}"
                                                                alt="User image"
                                                                class="me-2 me-md-3 rounded-circle border table-user-image">
                                                        @else
                                                            <img
                                                                src="{{ asset('assets/personal/images/system/system.jpg') }}"
                                                                alt="System image"
                                                                class="me-2 me-md-3 rounded-circle border table-user-image">
                                                        @endif

                                                        <div>
                                                            <div class="fw-medium">
                                                                @if($notification->fromUser)
                                                                    <span title="{{ $notification->fromUser->name }}">
                                                                        {{ Str::limit($notification->fromUser->name, 10) }}
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="text-primary fw-semibold">System:</span>
                                                                @endif
                                                            </div>

                                                            @switch($notification->type)
                                                                @case('follow')
                                                                    followed you.
                                                                    @break

                                                                @case('like')
                                                                    @if($notification->comment)
                                                                        liked your comment:
                                                                        <span
                                                                            title="{{ $notification->comment->message }}">
                                                                            {{ Str::limit($notification->comment->message, 25) }}
                                                                        </span>
                                                                    @else
                                                                        liked your post
                                                                    @endif
                                                                    @break

                                                                @case('save')
                                                                    saved your post.
                                                                    @break

                                                                @case('post_reported')
                                                                    Your post was removed due to multiple user reports.
                                                                    <br>
                                                                    If you think this was a mistake, you can submit an
                                                                    appeal.
                                                                    @break

                                                                @case('comment_reported')
                                                                    Your comment was removed due to multiple user
                                                                    reports.
                                                                    <br>
                                                                    If you think this was a mistake, you can submit an
                                                                    appeal.
                                                                    @break

                                                                @case('user_reported')
                                                                    Your account was banned due to multiple user
                                                                    reports.
                                                                    <br>
                                                                    If you think this was a mistake, you can submit an
                                                                    appeal.
                                                                    @break

                                                                @case('comment')
                                                                    @if(is_null($notification->comment->parent))
                                                                        commented:
                                                                        <span
                                                                            title="{{ $notification->comment->message }}">
                                                                                {{ Str::limit($notification->comment->message, 25) }}
                                                                            </span>
                                                                    @else
                                                                        replied to
                                                                        <span
                                                                            title="{{ $notification->comment->parent->user->name }}">
                                                                                {{ $notification->comment->parent->user->name }}:
                                                                            </span>
                                                                        <span
                                                                            title="{{ $notification->comment->message }}">
                                                                                {{ Str::limit($notification->comment->message, 25) }}
                                                                            </span>
                                                                    @endif
                                                                    @break
                                                            @endswitch
                                                            <div class="text-muted small">
                                                                {{ $notification->created_at->format('d M Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        @if($notification->post)
                                                            <img
                                                                src="{{ asset('storage/' . $notification->post->preview_image) }}"
                                                                alt="Post image"
                                                                title="Post image"
                                                                class="me-2 me-md-3 rounded table-post-preview-img">
                                                        @endif

                                                        @if($notification->post)
                                                            <span class="table-title-clamp"
                                                                  title="{{ $notification->post->title }}">
                                                                {{ Str::limit($notification->post->title, 30) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($notification->comment)
                                                        <span class="table-title-clamp"
                                                              title="{{ $notification->comment->message }}">
                                                            {{ Str::limit($notification->comment->message, 30) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        @if($notification->post)
                                                            <a href="{{ route('post.show', $notification->post->id) }}"
                                                               title="View">
                                                                <i class="fa-solid fa-eye text-primary"></i>
                                                            </a>
                                                        @endif

                                                        <form
                                                            action="{{ route('personal.notification.delete', $notification->id) }}"
                                                            method="POST" class="d-inline m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="border-0 bg-transparent p-0"
                                                                    title="Delete"
                                                                    onclick="return confirm('Delete notification?')">
                                                                <i class="fa-solid fa-trash text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($notifications->hasPages())
                                <div class="overflow-x-auto d-flex justify-content-start mb-2">
                                    {{ $notifications->links('personal::blade.pagination.bootstrap-4') }}
                                </div>
                            @endif
                        @else
                            <p class="text-muted mb-4">You have no notifications.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
