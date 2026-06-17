@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Tags</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tags</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <a href="{{ route('admin.tag.create') }}" class="btn btn-primary mb-4">
                            <i class="fa-solid fa-plus me-1"></i>
                            Create
                        </a>

                        @if($tags->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">ID</th>
                                            <th class="px-4 border-0">Title</th>
                                            <th class="px-4 border-0">Status</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tags as $tag)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">{{ $tag->id }}</td>
                                                <td class="border-0 border-top px-4" title="{{ $tag->title }}">
                                                    {{ Str::limit($tag->title, 15)}}
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    @if($tag->trashed())
                                                       <span class="text-danger">Deleted</span>
                                                    @else
                                                        <span class="text-success">Active</span>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('admin.tag.show', $tag->id) }}" title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>

                                                         @if(!$tag->trashed())
                                                            <a href="{{ route('admin.tag.edit', $tag->id) }}" title="Edit">
                                                                <i class="fa-solid fa-pen text-success"></i>
                                                            </a>

                                                            <form action="{{ route('admin.tag.delete', $tag->id) }}" method="POST" class="d-inline m-0">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="border-0 bg-transparent p-0" title="Delete" onclick="return confirm('Delete tag?')">
                                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                                </button>
                                                            </form>
                                                         @endif

                                                        @if($tag->trashed())
                                                            <form action="{{ route('admin.tag.restore', $tag->id) }}" method="POST" class="d-inline m-0">
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
                            <p class="text-muted mb-4">There are no tags yet.</p>
                        @endif

                        <div class="overflow-x-auto d-flex justify-content-start mb-2">
                            {{ $tags->links('admin::blade.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
