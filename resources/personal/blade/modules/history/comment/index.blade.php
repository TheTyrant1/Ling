@extends('personal::blade.layouts.personal')

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
                            <li class="breadcrumb-item"><a href="{{ route('personal.history.index') }}">History</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Comments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        @if($comments->count() > 1)
                            <div class="col-12 col-md-4 col-lg-2">
                                <form method="GET" action="{{ route('personal.history.comment.index') }}" class="d-flex justify-content-start mb-4">
                                    <select name="sort" class="form-select" onchange="this.form.submit()">
                                        <option value="latest" {{ (isset($sort) && $sort == 'latest') ? 'selected' : '' }}>
                                            Latest
                                        </option>
                                        <option
                                            value="popular" {{ (isset($sort) && $sort == 'popular') ? 'selected' : '' }}>
                                            Popular
                                        </option>
                                    </select>
                                </form>
                            </div>
                        @endif

                        @if($comments->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">Message</th>
                                            <th class="px-4 border-0">Post</th>
                                            <th class="px-4 border-0">Activity</th>
                                            <th class="px-4 border-0">Commented</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($comments as $comment)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img
                                                            src="{{ Storage::url($comment->user->profile_image) }}"
                                                            alt="User image"
                                                            class="rounded-circle border table-user-image"
                                                        >
                                                        <div>
                                                            <div class="fw-medium" title="{{ $comment->user->name }}">
                                                                {{ Str::limit($comment->user->name, 10) }}
                                                            </div>

                                                            <div class="text-muted small" title="{{ $comment->message }}">
                                                                {{ Str::limit($comment->message, 35) }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        <img
                                                            src="{{ Storage::url($comment->post->preview_image) }}"
                                                            alt="Post image"
                                                            title="Post image"
                                                            class="me-2 me-md-3 rounded table-post-preview-img">

                                                        <span class="table-title-clamp"
                                                              title="{{ $comment->post->title }}">
                                                        {{ Str::limit($comment->post->title, 35) }}
                                                    </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center gap-3 small text-muted">
                                                        <span class="d-flex align-items-center gap-1" title="Like">
                                                            <i class="fa-solid fa-heart"></i>
                                                            {{ Number::abbreviate($comment->likes_count) }}

                                                            @if($comment->today_likes_count > 0)
                                                                <span class="text-success fw-bold table-stat-badge ms-2">
                                                                    +{{ Number::abbreviate($comment->today_likes_count) }}
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <span class="text"
                                                          title="Commented: {{ $comment->created_at->format('d M Y H:i') }}">
                                                        {{ $comment->created_at->format('d M Y') }}
                                                    </span>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('post.show', $comment->post_id) }}" title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('personal.history.comment.delete', $comment->id) }}"
                                                            method="POST" class="d-inline m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="border-0 bg-transparent"
                                                                    title="Delete">
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
                        @else
                            <p class="text-muted mb-4">You haven't written any comments.</p>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <a href="{{ route('personal.history.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                            @if($comments->hasPages())
                                <div class="overflow-x-auto">
                                    {{ $comments->links('personal::blade.pagination.bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
