@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Updating a tag</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.tag.index') }}">Tags</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Updating a tag</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <form action="{{ route('admin.tag.update', $tag->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <div class="mb-4">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter title"
                                           value="{{ $tag->title }}">
                                    @error('title')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="{{ url()->previous() ?: route('admin.tag.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                        <i class="fa-solid fa-angle-left"></i>
                                    </a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
