@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>User</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($user->name, 20) }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card mb-4">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th class="px-4 border-0">ID</th>
                                        <th class="px-4 border-0">User</th>
                                        <th class="px-4 border-0">Role</th>
                                        <th class="px-4 border-0">Status</th>
                                        <th class="px-4 border-0">Registered</th>
                                        <th class="px-4 border-0">Changed</th>
                                        <th class="px-4 border-0">Deleted</th>
                                        <th class="px-4 border-0">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="align-middle">
                                        <td class="border-0 border-top px-4">{{ Str::limit($user->id, 5) }}</td>
                                        <td class="border-0 border-top px-4">
                                            <img
                                                src="{{ asset('storage/' . $user->profile_image) }}"
                                                alt="User image"
                                                title="User image"
                                                class="me-2 me-md-3 rounded-circle border table-user-image">
                                            <span class="fw-medium" title="{{ $user->name }}">
                                                {{ Str::limit($user->name, 15)}}
                                            </span>
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            @if($user->role_id == 1)
                                                <span>Admin</span>
                                            @else
                                                <span>User</span>
                                            @endif
                                        </td>

                                        <td class="border-0 border-top px-4">
                                            @if($user->trashed())
                                                <span class="text-danger">Deleted</span>
                                            @elseif($user->status_id == 1)
                                                <span class="text-success">Active</span>
                                            @else
                                                <span class="text-danger">Banned</span>
                                            @endif
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            <span class="text" title="Registered: {{ $user->created_at->format('d.m.Y H:i') }}">
                                                <i class="fa-solid fa-calendar-days me-2"></i>
                                                {{ $user->created_at->format('d.m.Y') }}
                                            </span>
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            @if($user->updated_at->gt($user->created_at))
                                                <span class="text-primary" title="Changed: {{ $user->updated_at->format('d.m.Y H:i') }}">
                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                    {{ $user->updated_at->format('d.m.Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">No changes</span>
                                            @endif
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            @if($user->deleted_at)
                                                <span class="text-danger" title="Deleted: {{ $user->deleted_at->format('d.m.Y H:i') }}">
                                                    <i class="fa-solid fa-calendar-xmark me-2"></i>
                                                    {{ $user->deleted_at->format('d.m.Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">No changes</span>
                                            @endif
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            <div class="d-flex gap-5 align-items-center">
                                                @if(!$user->trashed())
                                                    <a href="{{ route('admin.user.edit', $user->id) }}" title="Edit">
                                                        <i class="fa-solid fa-pen text-success"></i>
                                                    </a>

                                                    <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                                          class="d-inline m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="border-0 bg-transparent p-0" title="Delete" onclick="return confirm('Delete user?')">
                                                            <i class="fa-solid fa-trash text-danger"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($user->trashed())
                                                    <form action="{{ route('admin.user.restore', $user->id) }}" method="POST" class="d-inline m-0">
                                                        @csrf
                                                        <button type="submit" class="border-0 bg-transparent table-restore-btn p-0" title="Restore">
                                                            <i class="fa-solid fa-trash-arrow-up"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
