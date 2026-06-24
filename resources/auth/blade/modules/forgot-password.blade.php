@extends('auth::blade.layouts.auth')

@section('content')
    <div class="mb-4 text-sm text-gray-400">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <div class="group relative mt-1 block w-full">
                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-gray-400 group-focus-within:text-[#5FAD65]">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Your email address"
                       class="block w-full rounded-md shadow-sm text-gray-400 border-gray-300 ps-10
                              focus:border-transparent
                              focus:ring
                              focus:ring-[#5FAD65]
                              focus:ring-opacity-50
                              group-focus-within:text-[#5FAD65]
                              placeholder:text-gray-400
                              focus:placeholder:text-[#5FAD65]"
                       required
                       autofocus>
            </div>

            @error('email')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit"
                    class="ms-3 inline-flex items-center px-4 py-2
                        bg-[#5FAD65]
                        hover:bg-[#4A9350]
                        border border-transparent rounded-md
                        font-semibold text-xs text-white tracking-widest
                        focus:outline-none focus:ring-2 focus:ring-[#4A9350] focus:ring-offset-2
                        transition ease-in-out duration-150">
                Email Password Reset Link
            </button>
        </div>
    </form>
@endsection
