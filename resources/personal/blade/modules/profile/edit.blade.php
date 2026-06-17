@extends('personal::blade.layouts.personal')

@section('content')
    <div class="app-main">
        <div class="app-content">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary card-outline mb-4 text-center">
                            <div class="card-body box-profile p-4">
                                <form action="{{ route('personal.profile.update', $user->id) }}"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      data-component="avatar-uploader">
                                    @csrf
                                    @method('PATCH')

                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                                             alt="User image"
                                             title="User image"
                                             class="img-fluid rounded-circle user-profile-image avatar-preview">

                                        <label for="avatarInput"
                                               class="bg-primary text-white rounded-circle position-absolute d-flex align-items-center justify-content-center user-profile-image-upload-btn">
                                            <i class="fa-solid fa-upload fa-xs"></i>
                                        </label>

                                        <input type="file" id="avatarInput" name="profile_image" class="d-none avatar-input" accept="image/*">
                                    </div>

                                    <h3 class="profile-username text-center mb-2">{{ Str::limit($user->name, 20) }}</h3>

                                    <button type="submit" class="btn btn-primary btn-sm d-none avatar-save-btn">Save</button>
                                </form>
                            </div>
                        </div>

                        <div class="card mb-4 p-4">
                            <form action="{{ route('personal.profile.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <h5 class="mb-1">Profile Information</h5>
                                <p class="text-muted small mb-4">Update your account's profile information and email address.</p>

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Info</button>
                                </div>
                            </form>
                        </div>

                        <div class="card mb-4 p-4">
                            <form action="{{ route('personal.profile.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <h5 class="mb-1">Update Password</h5>
                                <p class="text-muted small mb-4">Ensure your account is using a long, random password to stay secure.</p>

                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                                    @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" placeholder="New Password">
                                    @error('new_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>

                        <div class="card mb-4 p-4 border-danger">
                            <form action="{{ route('personal.profile.delete', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <h5 class="text-danger mb-1">Delete Account</h5>
                                <p class="text-muted small mb-4">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to permanently delete your account?')">
                                        Delete Account
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
