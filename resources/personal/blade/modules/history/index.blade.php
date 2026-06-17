@extends('personal::blade.layouts.personal')

@php
    use Illuminate\Support\Number;
@endphp

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>History</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb d-flex justify-content-sm-end">
                            <li class="breadcrumb-item active" aria-current="page">History</li>
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
                            <div class="inner">
                                <h3 class="text-body d-inline-flex align-items-center">
                                    {{ Number::abbreviate($data['viewsCount']) }}

                                    @if($data['viewsToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['viewsToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Views</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-regular fa-eye"></i>
                                </div>
                            </div>

                            <a href="{{ route('personal.history.view.index') }}"
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
                                    {{ Number::abbreviate($data['likesCount']) }}

                                    @if($data['likesToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['likesToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Likes</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                            </div>

                            <a href="{{ route('personal.history.like.index') }}"
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
                                    {{ Number::abbreviate($data['savesCount']) }}

                                    @if($data['savesToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['savesToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Saves</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-regular fa-bookmark"></i>
                                </div>
                            </div>

                            <a href="{{ route('personal.history.save.index') }}"
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

                            <a href="{{ route('personal.history.comment.index') }}"
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

                            <a href="{{ route('personal.history.post.index') }}"
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

                            <a href="{{ route('personal.history.appeal.index') }}"
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
                                    {{ Number::abbreviate($data['reportsCount']) }}

                                    @if($data['reportsToday'] > 0)
                                        <span class="text-success fw-bold small-box-stat-number ms-2">
                                            +{{ Number::abbreviate($data['reportsToday']) }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-body">Reports</p>
                                <div class="small-box-icon d-none d-sm-flex align-items-center text-body">
                                    <i class="fa-regular fa-flag"></i>
                                </div>
                            </div>

                            <a href="{{ route('personal.history.report.index') }}"
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
