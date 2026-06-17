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
                        <h3>Save</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('personal.history.index') }}">History</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('personal.history.save.index') }}">Saves</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 20) }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th class="px-4 border-0">Post</th>
                                        <th class="px-4 border-0">Activity</th>
                                        <th class="px-4 border-0">Saved</th>
                                        <th class="px-4 border-0">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
                                                        <span class="text-success fw-bold table-stat-badge ms-2">
                                                            +{{ Number::abbreviate($post->today_views_count) }}
                                                        </span>
                                                    @endif
                                                </span>

                                                <span class="d-flex align-items-center gap-1" title="Like">
                                                    <i class="fa-solid fa-heart"></i>
                                                    {{ Number::abbreviate($post->likes_count) }}

                                                    @if($post->today_likes_count > 0)
                                                        <span class="text-success fw-bold table-stat-badge ms-2">
                                                            +{{ Number::abbreviate($post->today_likes_count) }}
                                                        </span>
                                                    @endif
                                                </span>

                                                <span class="d-flex align-items-center gap-1" title="Save">
                                                    <i class="fa-solid fa-bookmark"></i>
                                                    {{ Number::abbreviate($post->saves_count) }}

                                                    @if($post->today_saves_count > 0)
                                                        <span class="text-success fw-bold table-stat-badge ms-2">
                                                            +{{ Number::abbreviate($post->today_saves_count) }}
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            <span class="text"
                                                  title="Saved: {{ $post->pivot->created_at->format('d M Y H:i') }}">
                                                {{ $post->pivot->created_at->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            <div class="d-flex gap-5 align-items-center">
                                                <a href="{{ route('post.show', $post->id) }}" title="View">
                                                    <i class="fa-solid fa-eye text-primary"></i>
                                                </a>

                                                <form action="{{ route('personal.history.save.delete', $post->id) }}"
                                                      method="POST"
                                                      class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent p-0"
                                                            title="Delete">
                                                        <i class="fa-solid fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('personal.history.save.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
