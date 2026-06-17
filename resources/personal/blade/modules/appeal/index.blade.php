@extends('personal::blade.layouts.personal')

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

                        <a href="{{ route('personal.appeal.create') }}" class="btn btn-primary mb-4">
                            <i class="fa-solid fa-plus me-1"></i>
                            Create
                        </a>

                        @if($appeals->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">Type</th>
                                            <th class="px-4 border-0">Status</th>
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
                                                <td class="border-0 border-top px-4" title="{{ $appeal->user_message }}">
                                                    {{ Str::limit($appeal->user_message, 25) }}
                                                </td>
                                                <td class="border-0 border-top px-4" title="{{ $appeal->admin_message }}">
                                                    {{ Str::limit($appeal->admin_message, 25) }}
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <span class="text"
                                                          title="Created: {{ $appeal->created_at->format('d.m.Y H:i') }}">
                                                        <i class="fa-solid fa-calendar-days me-2"></i>
                                                        {{ $appeal->created_at->format('d.m.Y') }}
                                                    </span>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($appeal->user_updated_at?->gt($appeal->created_at))
                                                        <span class="text-primary"
                                                              title="Changed: {{ $appeal->user_updated_at->format('d.m.Y H:i') }}">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            {{ $appeal->user_updated_at->format('d.m.Y') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">No changes</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('personal.appeal.show', $appeal->id) }}" title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>

                                                        <a href="{{ route('personal.appeal.edit', $appeal->id) }}" title="Edit">
                                                            <i class="fa-solid fa-pen text-success"></i>
                                                        </a>

                                                        <form action="{{ route('personal.appeal.delete', $appeal->id) }}" method="POST" class="d-inline m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="border-0 bg-transparent p-0"
                                                                    title="Delete"
                                                                    onclick="return confirm('Delete this appeal?')">
                                                                <i class="fa-solid fa-trash text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="overflow-x-auto d-flex justify-content-start mb-4">
                            {{ $appeals->links('personal::blade.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
