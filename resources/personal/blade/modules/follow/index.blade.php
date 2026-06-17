@extends('personal::blade.layouts.personal')

@section('content')
    <div class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3>Following</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-4">
                        @if($following->count())
                            <div class="card mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap mb-0">
                                        <thead>
                                        <tr>
                                            <th class="px-4 border-0">User</th>
                                            <th class="px-4 border-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($following as $user)
                                            <tr class="align-middle">
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex align-items-center">
                                                        <img
                                                            src="{{ asset('storage/' . $user->profile_image) }}"
                                                            alt="User image"
                                                            title="User image"
                                                            class="me-2 me-md-3 rounded-circle border table-user-image">
                                                        <span class="fw-medium title-clamp" title="{{ $user->name }}">
                                                            {{ Str::limit($user->name, 15) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="border-0 border-top px-4">
                                                    <div class="d-flex gap-5 align-items-center">
                                                        <a href="{{ route('user.show', $user->id) }}"
                                                           title="View">
                                                            <i class="fa-solid fa-eye text-primary"></i>
                                                        </a>

                                                        <form
                                                            action="{{ route('user.follow.store', $user->id) }}"
                                                            method="POST" class="d-inline m-0">
                                                            @csrf
                                                            <button type="submit" class="border-0 bg-transparent p-0"
                                                                    title="Unfollow"
                                                                    onclick="return confirm('Unfollow?')">
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
                            @if($following->hasPages())
                                <div class="overflow-x-auto d-flex justify-content-start mb-4">
                                    {{ $following->links('personal::blade.pagination.bootstrap-4') }}
                                </div>
                            @endif
                        @else
                            <p class="text-muted mb-4">You have no following.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
