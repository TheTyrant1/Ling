@extends('personal::blade.layouts.personal')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Updating a post</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('personal.post.index') }}">Posts</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Updating a post</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6">
                        <form action="{{ route('personal.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">Title</label>
                                <textarea name="title" class="form-control" rows="3"
                                          placeholder="Enter post title">{{ old('title', $post->title) }}</textarea>
                                @error('title')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">Content</label>
                                <div id="editor" name="content">
                                    {!! old('content', $post->content) !!}
                                </div>
                                @error('content')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Add preview image</label>
                                <div class="mb-4">
                                    <img src="{{ asset( 'storage/' . $post->preview_image) }}" alt="preview_image" class="rounded img-fluid">
                                </div>
                                <div class="input-group">
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="previewInput"
                                        name="preview_image"
                                    >
                                </div>

                                @error('preview_image')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Add main image</label>
                                <div class="mb-4">
                                    <img src="{{ asset( 'storage/' . $post->main_image) }}" alt="main_image" class="rounded img-fluid">
                                </div>
                                <div class="input-group">
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="mainInput"
                                        name="main_image"
                                    >
                                </div>

                                @error('main_image')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">Tag</label>
                                <textarea name="tags" class="form-control" rows="3"
                                          placeholder="Use commas to separate tags">{{ old('tags', $post->tags->map(fn($tag) => '#' . $tag->title)->implode(', ')) }}</textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ url()->previous() ?: route('personal.post.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                    <i class="fa-solid fa-angle-left"></i>
                                </a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
