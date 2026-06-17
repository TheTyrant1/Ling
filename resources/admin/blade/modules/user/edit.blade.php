@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Updating a user</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Updating a user</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-2">
                        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="form-group mb-4">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role_id">
                                    <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status_id">
                                    <option value="1" {{ $user->status_id == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $user->status_id == 2 ? 'selected' : '' }}>Banned</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ url()->previous() ?: route('admin.user.index') }}" class="btn btn-outline-secondary" aria-label="Back">
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
