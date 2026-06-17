@extends('personal::blade.layouts.personal')

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
                            <li class="breadcrumb-item"><a href="{{ route('personal.appeal.index') }}">Appeals</a></li>
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
                        <form action="{{ route('personal.appeal.update', $appeal->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-4">
                                <label class="form-label">Select a type</label>

                                <select name="type_id" class="form-select">
                                    <option value="1" {{ $appeal->type_id == 1 ? 'selected' : '' }}>User</option>
                                    <option value="2" {{ $appeal->type_id == 2 ? 'selected' : '' }}>Post</option>
                                    <option value="3" {{ $appeal->type_id == 3 ? 'selected' : '' }}>Comment</option>
                                </select>
                                @error('user_message')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">User message</label>
                                <textarea name="user_message" class="form-control" rows="3"
                                          placeholder="Make sure to add the title of the post or comment for faster support.">{{ old('user_message', $appeal->user_message) }}</textarea>
                                @error('user_message')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ url()->previous() ?: route('personal.appeal.index') }}" class="btn btn-outline-secondary" aria-label="Back">
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
