@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Appeals</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @if(!$appeals->count())
                            <p class="text-muted mb-4">
                                You don't have any appeals yet.
                            </p>
                        @endif

                        @if($appeals->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">ID</th>
                                            <th class="px-4 border-0">Type</th>
                                            <th class="px-4 border-0">Status</th>
                                            <th class="px-4 border-0">User_ID</th>
                                            <th class="px-4 border-0">User</th>
                                            <th class="px-4 border-0">User message</th>
                                            <th class="px-4 border-0">Moderator message</th>
                                            <th class="px-4 border-0">Created</th>
                                            <th class="px-4 border-0">Changed</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($appeals as $appeal)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">
                                                    {{ $appeal->id }}
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($appeal->type_id === 1)
                                                        <span>User</span>
                                                    @elseif($appeal->type_id === 2)
                                                        <span>Post</span>
                                                    @else
                                                        <span>Comment</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($appeal->status_id === 1)
                                                        <span class="text-muted">Pending</span>
                                                    @elseif($appeal->status_id === 2)
                                                        <span class="text-success">Approved</span>
                                                    @else
                                                        <span class="text-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    {{ $appeal->user_id }}
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        <img
                                                            src="{{ Storage::url($appeal->user->profile_image) }}"
                                                            alt="User image"
                                                            title="User image"
                                                            class="me-2 me-md-3 rounded-circle border table-user-image">
                                                        <span class="fw-medium title-clamp" title="{{ $appeal->user->name }}">
                                                            {{ Str::limit($appeal->user->name, 15) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4" title="{{ $appeal->user_message }}">
                                                    {{ Str::limit($appeal->user_message, 20) }}
                                                </td>
                                                <td class="border-0 border-top px-4" title="{{ $appeal->admin_message }}">
                                                    {{ Str::limit($appeal->admin_message, 20) }}
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <span class="text"
                                                          title="Created: {{ $appeal->created_at->format('d.m.Y H:i') }}">
                                                        <i class="fa-solid fa-calendar-days me-2"></i>
                                                        {{ $appeal->created_at->format('d.m.Y') }}
                                                    </span>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($appeal->admin_updated_at?->gt($appeal->created_at))
                                                        <span class="text-primary"
                                                              title="Changed: {{ $appeal->admin_updated_at->format('d.m.Y H:i') }}">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            {{ $appeal->admin_updated_at->format('d.m.Y') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">No changes</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('admin.appeal.show', $appeal->id) }}" title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>

                                                        <a href="{{ route('admin.appeal.edit', $appeal->id) }}" title="Edit">
                                                            <i class="fa-solid fa-pen text-success"></i>
                                                        </a>

                                                        <form action="{{ route('admin.appeal.delete', $appeal->id) }}" method="POST" class="d-inline m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="border-0 bg-transparent p-0"
                                                                    title="Delete"
                                                                    onclick="return confirm('Delete this appeal?')">
                                                                <i class="fa-solid fa-trash text-danger"></i>
                                                            </button>
                                                        </form>
                                                        @if($appeal->status_id === 1)
                                                            <form action="{{ route('admin.appeal.approve', $appeal->id) }}" method="POST" class="d-inline m-0">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="border-0 bg-transparent p-0"
                                                                        title="Approve"
                                                                        onclick="return confirm('Approve this appeal?')">
                                                                    <i class="fa-solid fa-check text-success"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.appeal.reject', $appeal->id) }}" method="POST" class="d-inline m-0">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="border-0 bg-transparent p-0"
                                                                        title="Reject"
                                                                        onclick="return confirm('Reject this appeal?')">
                                                                    <i class="fa-solid fa-xmark text-danger"></i>
                                                                </button>
                                                            </form>
                                                        @elseif($appeal->status_id === 2)
                                                            <form action="{{ route('admin.appeal.reject', $appeal->id) }}" method="POST" class="d-inline m-0">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="border-0 bg-transparent p-0"
                                                                        title="Reject"
                                                                        onclick="return confirm('Reject this appeal?')">
                                                                    <i class="fa-solid fa-xmark text-danger"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('admin.appeal.approve', $appeal->id) }}" method="POST" class="d-inline m-0">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="border-0 bg-transparent p-0"
                                                                        title="Approve"
                                                                        onclick="return confirm('Approve this appeal?')">
                                                                    <i class="fa-solid fa-check text-success"></i>
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
                        @endif

                        <div class="overflow-x-auto d-flex justify-content-start mb-2">
                            {{ $appeals->links('admin::blade.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
