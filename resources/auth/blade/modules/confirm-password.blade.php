@extends('auth::blade.layouts.auth')

@section('content')
    <div class="mb-4 text-sm text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div>
            <div class="group relative mt-1 block w-full">

                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-gray-400 group-focus-within:text-[#2E937A]">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <input id="password"
                       type="password"
                       name="password"
                       placeholder="{{ __('Password') }}"
                       class="block w-full rounded-md shadow-sm text-gray-400 border-gray-300 ps-10
                              focus:border-transparent
                              focus:ring
                              focus:ring-[#2E937A]
                              focus:ring-opacity-50
                              group-focus-within:text-[#2E937A]
                              placeholder:text-gray-400
                              focus:placeholder:text-[#2E937A]"
                       required
                       autocomplete="current-password"
                       autofocus>

                <button type="button"
                        onmousedown="event.preventDefault()"
                        onclick="const input = document.getElementById('password');
                                 const icon = this.querySelector('i');
                                 if (input.type === 'password') {
                                     input.type = 'text';
                                     icon.classList.replace('fa-eye', 'fa-eye-slash');
                                 }
                                 else {
                                     input.type = 'password';
                                     icon.classList.replace('fa-eye-slash', 'fa-eye');
                                 }"
                        class="absolute inset-y-0 end-0 flex items-center pe-3 text-gray-400 group-focus-within:text-[#2E937A] transition-colors duration-150">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            @error('password')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit"
                    class="ms-3 inline-flex items-center px-4 py-2
                        bg-[#2E937A]
                        hover:bg-[#1C594A]
                        border border-transparent rounded-md
                        font-semibold text-xs text-white tracking-widest
                        focus:outline-none focus:ring-2 focus:ring-[#1C594A] focus:ring-offset-2
                        transition ease-in-out duration-150">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
@endsection
