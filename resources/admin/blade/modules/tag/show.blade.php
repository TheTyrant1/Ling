@extends('admin::blade.layouts.admin')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Tag</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.tag.index') }}">Tags</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($tag->title, 20) }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th class="px-4 border-0">ID</th>
                                        <th class="px-4 border-0">Title</th>
                                        <th class="px-4 border-0">Status</th>
                                        <th class="px-4 border-0">Created</th>
                                        <th class="px-4 border-0">Changed</th>
                                        <th class="px-4 border-0">Deleted</th>
                                        <th class="px-4 border-0">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
                                            <span class="text"
                                                  title="Created: {{ $tag->created_at->format('d.m.Y H:i') }}">
                                                <i class="fa-solid fa-calendar-days me-2"></i>
                                                {{ $tag->created_at->format('d.m.Y') }}
                                            </span>
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            @if($tag->updated_at->gt($tag->created_at))
                                                <span class="text-primary"
                                                      title="Changed: {{ $tag->updated_at->format('d.m.Y H:i') }}">
                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                    {{ $tag->updated_at->format('d.m.Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">No changes</span>
                                            @endif
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            @if($tag->trashed())
                                                <span class="text-danger"
                                                      title="Deleted: {{ $tag->deleted_at->format('d.m.Y H:i') }}">
                                                    <i class="fa-solid fa-calendar-xmark me-2"></i>
                                                    {{ $tag->deleted_at->format('d.m.Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">No changes</span>
                                            @endif
                                        </td>
                                        <td class="border-0 border-top px-4">
                                            <div class="d-flex gap-5 align-items-center">
                                                @if(!$tag->trashed())
                                                    <a href="{{ route('admin.tag.edit', $tag->id) }}"
                                                       title="Edit">
                                                        <i class="fa-solid fa-pen text-success"></i>
                                                    </a>

                                                    <form action="{{ route('admin.tag.delete', $tag->id) }}"
                                                          method="POST" class="d-inline m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="border-0 bg-transparent p-0"
                                                                title="Delete" onclick="return confirm('Delete tag?')">
                                                            <i class="fa-solid fa-trash text-danger"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($tag->trashed())
                                                    <form action="{{ route('admin.tag.restore', $tag->id) }}"
                                                          method="POST" class="d-inline m-0">
                                                        @csrf
                                                        <button type="submit" class="border-0 bg-transparent table-restore-btn p-0"
                                                                title="Restore">
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
                            <a href="{{ route('admin.tag.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
