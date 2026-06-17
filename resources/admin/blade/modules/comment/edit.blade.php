@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Updating a comment</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.comment.index') }}">Comments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Updating a comment</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-2">
                        <form action="{{ route('admin.comment.update', $comment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label class="form-label">Status</label>
                                <select class="form-select mb-4" name="status_id">
                                    <option value="1" {{ $comment->status_id == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $comment->status_id == 2 ? 'selected' : '' }}>Banned</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ url()->previous() ?: route('admin.comment.index') }}" class="btn btn-outline-secondary" aria-label="Back">
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
