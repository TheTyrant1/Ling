@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Users</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-4">
                            <i class="fa-solid fa-plus me-1"></i>
                            Create
                        </a>

                        @if($users->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">ID</th>
                                            <th class="px-4 border-0">User</th>
                                            <th class="px-4 border-0">Status</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">{{ Str::limit($user->id, 5) }}</td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        <img
                                                            src="{{ asset('storage/' . $user->profile_image) }}"
                                                            alt="User image"
                                                            title="User image"
                                                            class="me-2 me-md-3 rounded-circle border table-user-image">
                                                        <span class="fw-medium" title="{{ $user->name }}">
                                                            {{ Str::limit($user->name, 15) }}
                                                        </span>
                                                    </div>
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
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('admin.user.show', $user->id) }}" title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>

                                                        @if(!$user->trashed())
                                                            <a href="{{ route('admin.user.edit', $user->id) }}" title="Edit">
                                                                <i class="fa-solid fa-pen text-success"></i>
                                                            </a>

                                                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" class="d-inline m-0">
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
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-3">There are no users yet.</p>
                        @endif

                        <div class="overflow-x-auto d-flex justify-content-start">
                            {{ $users->links('admin::blade.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
