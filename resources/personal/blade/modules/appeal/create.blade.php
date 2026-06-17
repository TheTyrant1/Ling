@extends('personal::blade.layouts.personal')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Creating an appeal</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('personal.appeal.index') }}">Appeal</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Creating an appeal</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <form action="{{ route('personal.appeal.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <label class="form-label">Select a type</label>

                                <select name="type_id" class="form-select">
                                    <option value="1">User</option>
                                    <option value="2">Post</option>
                                    <option value="3">Comment</option>
                                </select>
                                @error('type_id')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">User message</label>
                                <textarea name="user_message" class="form-control" rows="3" placeholder="Make sure to add the title of the post or comment for faster support."></textarea>
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
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
