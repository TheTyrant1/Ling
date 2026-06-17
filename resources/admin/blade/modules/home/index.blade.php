@extends('admin::blade.layouts.admin')

@php
    use Illuminate\Support\Number;
@endphp

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Home</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-body">
                            <div class="inner text-center text-sm-start">
                                <h3 class="text-body d-inline-flex align-items-center">
                                    {{ Number::abbreviate($data['postsCount']) }}

                                    @if($data['postsToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['postsToday']) }}
                                        </span>
                                    @endif
                                </h3>

                                <p class="text-body">Posts</p>

                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-solid fa-inbox"></i>
                                </div>
                            </div>

                            <a href="{{ route('admin.post.index') }}"
                               class="small-box-footer text-body d-flex justify-content-center align-items-center gap-2 text-decoration-none">
                                <span>Details</span>
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-body">
                            <div class="inner">
                                <h3 class="text-body d-inline-flex align-items-center">
                                    {{ Number::abbreviate($data['tagsCount']) }}

                                    @if($data['tagsToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['tagsToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Tags</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-solid fa-hashtag"></i>
                                </div>
                            </div>

                            <a href="{{ route('admin.tag.index') }}"
                               class="small-box-footer text-body d-flex justify-content-center align-items-center gap-2 text-decoration-none">
                                <span>Details</span>
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-body">
                            <div class="inner">
                                <h3 class="text-body d-inline-flex align-items-center">
                                    {{ Number::abbreviate($data['usersCount']) }}

                                    @if($data['usersToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['usersToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Users</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                            </div>

                            <a href="{{ route('admin.user.index') }}"
                               class="small-box-footer text-body d-flex justify-content-center align-items-center gap-2 text-decoration-none">
                                <span>Details</span>
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-body">
                            <div class="inner">
                                <h3 class="text-body d-inline-flex align-items-center">
                                    {{ Number::abbreviate($data['commentsCount']) }}

                                    @if($data['commentsToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['commentsToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Comments</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-regular fa-comment"></i>
                                </div>
                            </div>

                            <a href="{{ route('admin.comment.index') }}"
                               class="small-box-footer text-body d-flex justify-content-center align-items-center gap-2 text-decoration-none">
                                <span>Details</span>
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-body">
                            <div class="inner">
                                <h3 class="text-body d-inline-flex align-items-center">
                                    {{ Number::abbreviate($data['appealsCount']) }}

                                    @if($data['appealsToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['appealsToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Appeals</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-solid fa-gavel"></i>
                                </div>
                            </div>

                            <a href="{{ route('admin.appeal.index') }}"
                               class="small-box-footer text-body d-flex justify-content-center align-items-center gap-2 text-decoration-none">
                                <span>Details</span>
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
