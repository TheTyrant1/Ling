@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Updating a post</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.post.index') }}">Posts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Updating a post</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-2">
                        <form action="{{ route('admin.post.update', $post->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <label class="form-label">Status</label>
                            <select class="form-select mb-4" name="status_id">
                                <option value="1" {{ $post->status_id == 1 ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ $post->status_id == 2 ? 'selected' : '' }}>Banned</option>
                            </select>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ url()->previous() ?: route('admin.post.index') }}" class="btn btn-outline-secondary"
                                   aria-label="Back">
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
