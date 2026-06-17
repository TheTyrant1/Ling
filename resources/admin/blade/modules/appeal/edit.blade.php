@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Updating a appeal</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.appeal.index') }}">Appeals</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Updating a appeal</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <form action="{{ route('admin.appeal.update', $appeal->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label class="form-label fw-bold">Moderator message</label>
                                <textarea name="admin_message" class="form-control" rows="3"
                                          placeholder="Enter message here">{{ old('admin_message', $appeal->admin_message) }}</textarea>
                                @error('admin_message')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ url()->previous() ?: route('admin.appeal.index') }}" class="btn btn-outline-secondary"
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
