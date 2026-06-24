@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Creating a user</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Creating a user</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card mb-4">
                            <div class="card-body box-profile p-4">
                                <form action="{{ route('admin.user.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-4">
                                        <div>
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter your name" value="{{ old('name') }}">
                                            @error('name')
                                            <div class="text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div>
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                                            @error('email')
                                            <div class="text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div>
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="Enter your password">
                                            @error('password')
                                            <div class="text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div>
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                   placeholder="Confirm your password">
                                            @error('password')
                                            <div class="text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="form-label">Select a role</label>
                                        <select name="role_id" class="form-select">
                                            <option value="" selected disabled>Select a role</option>
                                            @foreach($roles as $role)
                                                <option
                                                    value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    @if($role->id === 1)
                                                        Admin
                                                    @else
                                                        User
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <div class="text-danger mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ url()->previous() ?: route('admin.user.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </a>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
