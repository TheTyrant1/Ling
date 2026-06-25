@extends('personal::blade.layouts.personal')

@php
    $type = request('type', 'user');
@endphp

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Reports</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-2 mb-4">
                        @if(auth()->user()->reports()->exists())
                            <form method="GET" action="{{ route('personal.history.report.index') }}">
                                <select name="type" class="form-select" onchange="this.form.submit()">
                                    <option value="user" {{ $type == 'user' ? 'selected' : '' }}>
                                        Users
                                    </option>
                                    <option value="post" {{ $type == 'post' ? 'selected' : '' }}>
                                        Posts
                                    </option>
                                    <option value="comment" {{ $type == 'comment' ? 'selected' : '' }}>
                                        Comments
                                    </option>
                                </select>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-5">
                        @if($reports->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">
                                                {{ ucfirst($type) }}
                                            </th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($reports as $report)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">
                                                    @if($type === 'user')
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Storage::url($report->reportable->profile_image) }}"
                                                                 alt="User image" class="me-2 me-md-3 rounded-circle border table-user-image">
                                                            <div class="fw-medium">
                                                                <span title="{{ $report->reportable->name }}">{{ Str::limit($report->reportable->name, 10) }}</span>
                                                            </div>
                                                        </div>
                                                    @elseif($type === 'post')
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Storage::url($report->reportable->preview_image) }}"
                                                                 alt="Post image" title="Post image" class="me-2 me-md-3 rounded table-post-preview-img">
                                                            <span class="table-title-clamp" title="{{ $report->reportable->title }}">
                                                                {{ Str::limit($report->reportable->title, 30) }}
                                                            </span>
                                                        </div>
                                                    @elseif($type === 'comment')
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Storage::url($report->reportable->user->profile_image) }}"
                                                                 alt="User image" class="me-2 me-md-3 rounded-circle border table-user-image">
                                                            <div class="fw-medium d-flex flex-column">
                                                                <span title="{{ $report->reportable->user->name }}">{{ Str::limit($report->reportable->user->name, 10) }}:</span>
                                                                <span title="{{ $report->reportable->message }}">{{ Str::limit($report->reportable->message, 10) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <a href="{{ $report->getUrl() }}" title="View">
                                                        <i class="fa-solid fa-eye text-primary"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-4">You have no reports.</p>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <a href="{{ route('personal.history.index') }}" class="btn btn-outline-secondary" aria-label="Back">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                            @if($reports->hasPages())
                                <div class="overflow-x-auto">
                                    {{ $reports->links('personal::blade.pagination.bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
