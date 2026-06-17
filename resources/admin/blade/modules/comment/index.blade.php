@extends('admin::blade.layouts.admin')

@php
    use Illuminate\Support\Number;
@endphp

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Comments</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Comments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-12 col-md-4 col-lg-2">
                            @if($comments->count() > 1)
                                <form method="GET" action="{{ route('admin.comment.index') }}" class="d-flex justify-content-start mb-4">
                                    <select name="sort" class="form-select" onchange="this.form.submit()">
                                        <option value="latest" {{ (isset($sort) && $sort == 'latest') ? 'selected' : '' }}>
                                            Latest
                                        </option>
                                        <option value="popular" {{ (isset($sort) && $sort == 'popular') ? 'selected' : '' }}>
                                            Popular
                                        </option>
                                    </select>
                                </form>
                            @endif
                        </div>

                        @if($comments->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">ID</th>
                                            <th class="px-4 border-0">Post</th>
                                            <th class="px-4 border-0">User</th>
                                            <th class="px-4 border-0">Message</th>
                                            <th class="px-4 border-0">Activity</th>
                                            <th class="px-4 border-0">Status</th>
                                            <th class="px-4 border-0">Created</th>
                                            <th class="px-4 border-0">Deleted</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($comments as $comment)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">{{ $comment->id }}</td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/' . $comment->post->preview_image) }}"
                                                             alt="Post image"
                                                             title="Post image"
                                                             class="me-2 me-md-3 rounded table-post-preview-img">

                                                        <span class="text-wrap table-title-clamp" title="{{ $comment->post->title }}">
                                                            {{ Str::limit($comment->post->title, 30) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        <img
                                                            src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                                            alt="User image"
                                                            title="User image"
                                                            class="me-2 me-md-3 rounded-circle border table-user-image">
                                                        <span class="fw-medium" title="{{ $comment->user->name }}">
                                                            {{ Str::limit($comment->user->name, 10) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4" title="{{ $comment->message }}">
                                                    {{ Str::limit($comment->message, 25) }}
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center gap-3 small text-muted">
                                                        <span class="d-flex align-items-center gap-1" title="Like">
                                                            <i class="fa-solid fa-heart"></i>
                                                            {{ Number::abbreviate($comment->likes_count) }}

                                                            @if($comment->today_likes_count > 0)
                                                                <span class="text-success fw-bold ms-2 table-stat-badge">
                                                                    +{{ Number::abbreviate($comment->today_likes_count) }}
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($comment->trashed())
                                                        <span class="text-danger">Deleted</span>
                                                    @elseif($comment->status_id == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">Banned</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <span class="text" title="Created: {{ $comment->created_at->format('d.m.Y H:i') }}">
                                                        <i class="fa-solid fa-calendar-days me-2"></i>
                                                        {{ $comment->created_at->format('d.m.Y') }}
                                                    </span>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($comment->trashed())
                                                        <span class="text-danger"
                                                              title="Deleted: {{ $comment->deleted_at->format('d.m.Y H:i') }}">
                                                            <i class="fa-solid fa-calendar-xmark me-1"></i>
                                                            {{ $comment->deleted_at->format('d.m.Y') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">No changes</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('admin.comment.show', $comment->id) }}"
                                                           title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>

                                                        @if(!$comment->trashed())
                                                            <a href="{{ route('admin.comment.edit', $comment->id) }}"
                                                               title="Edit">
                                                                <i class="fa-solid fa-pen text-success"></i>
                                                            </a>

                                                            <form action="{{ route('admin.comment.delete', $comment->id) }}"
                                                                  method="POST" class="d-inline m-0">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="border-0 bg-transparent p-0"
                                                                        title="Delete"
                                                                        onclick="return confirm('Delete comment?')">
                                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if($comment->trashed())
                                                            <form
                                                                action="{{ route('admin.comment.restore', $comment->id) }}"
                                                                method="POST" class="d-inline m-0">
                                                                @csrf
                                                                <button type="submit" class="border-0 bg-transparent table-restore-btn p-0"
                                                                        title="Restore">
                                                                    <i class="fa-solid fa-trash-arrow-up"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-4">There are no comments yet.</p>
                        @endif

                        <div class="overflow-x-auto d-flex justify-content-start mb-2">
                            {{ $comments->links('admin::blade.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
