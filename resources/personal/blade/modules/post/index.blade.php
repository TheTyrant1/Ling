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
                        <h3>Posts</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @if(!$posts->count())
                            <p class="text-muted mb-4">
                                You don't have any posts yet.
                            </p>
                        @endif

                        <div class="d-flex gap-3 align-items-center mb-4">
                            @if($posts->count() > 1)
                                <div class="col-8 col-md-4 col-lg-2">
                                    <form method="GET" action="{{ route('personal.post.index') }}">
                                        <select name="sort" class="form-select" onchange="this.form.submit()">
                                            <option
                                                value="latest" {{ (isset($sort) && $sort == 'latest') ? 'selected' : '' }}>
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
                            <div class="col-4 col-md-auto">
                                <a href="{{ route('personal.post.create') }}" class="btn btn-primary text-nowrap">
                                    <i class="fa-solid fa-plus me-1"></i>
                                    Create
                                </a>
                            </div>
                        </div>

                        @if($posts->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">Post</th>
                                            <th class="px-4 border-0">Activity</th>
                                            <th class="px-4 border-0">Status</th>
                                            <th class="px-4 border-0">Created</th>
                                            <th class="px-4 border-0">Changed</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($posts as $post)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/' . $post->preview_image) }}"
                                                             alt="Post image"
                                                             title="Post image"
                                                             class="me-2 me-md-3 rounded table-post-preview-img">

                                                        <span class="table-title-clamp"
                                                              title="{{ $post->title }}">
                                                            {{ Str::limit($post->title, 35) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center gap-3 small text-muted">
                                                        <span class="d-flex align-items-center gap-1" title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                            {{ Number::abbreviate($post->views_count) }}

                                                            @if($post->today_views_count > 0)
                                                                <span
                                                                    class="text-success fw-bold table-stat-badge ms-2">
                                                                    +{{ Number::abbreviate($post->today_views_count) }}
                                                                </span>
                                                            @endif
                                                        </span>

                                                        <span class="d-flex align-items-center gap-1" title="Like">
                                                            <i class="fa-solid fa-heart"></i>
                                                            {{ Number::abbreviate($post->likes_count) }}

                                                            @if($post->today_likes_count > 0)
                                                                <span
                                                                    class="text-success fw-bold table-stat-badge ms-2">
                                                                    +{{ Number::abbreviate($post->today_likes_count) }}
                                                                </span>
                                                            @endif
                                                        </span>

                                                        <span class="d-flex align-items-center gap-1" title="Save">
                                                            <i class="fa-solid fa-bookmark"></i>
                                                            {{ Number::abbreviate($post->saves_count) }}

                                                            @if($post->today_saves_count > 0)
                                                                <span
                                                                    class="text-success fw-bold table-stat-badge ms-2">
                                                                    +{{ Number::abbreviate($post->today_saves_count) }}
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($post->trashed())
                                                        <span class="text-danger">Deleted</span>
                                                    @elseif($post->status_id == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">Banned</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <span class="text"
                                                          title="Created: {{ $post->created_at->format('d.m.Y H:i') }}">
                                                        <i class="fa-solid fa-calendar-days me-2"></i>
                                                        {{ $post->created_at->format('d.m.Y') }}
                                                    </span>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($post->content_updated_at?->gt($post->created_at))
                                                        <span class="text-primary"
                                                              title="Changed: {{ $post->content_updated_at->format('d.m.Y H:i') }}">
                                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                                        {{ $post->content_updated_at->format('d.m.Y') }}
                                                    </span>
                                                    @else
                                                        <span class="text-muted">No changes</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('personal.post.show', $post->id) }}"
                                                           title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>

                                                        <a href="{{ route('personal.post.edit', $post->id) }}"
                                                           title="Edit">
                                                            <i class="fa-solid fa-pen text-success"></i>
                                                        </a>

                                                        <form
                                                            action="{{ route('personal.post.delete', $post->id) }}"
                                                            method="POST" class="d-inline m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="border-0 bg-transparent p-0"
                                                                    title="Delete"
                                                                    onclick="return confirm('Delete this post?\nYou can restore it within 30 days.')">
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
                            @if($posts->hasPages())
                                <div class="overflow-x-auto d-flex justify-content-start mb-2">
                                    {{ $posts->links('personal::blade.pagination.bootstrap-4') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
