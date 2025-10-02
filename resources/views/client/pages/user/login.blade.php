@extends('client.layout.user')

@section('main_content')
    <div class="bg-gray-100 p-4 border-b border-gray-200 rounded-t-lg">
        <h3 class="text-xl font-semibold text-gray-800">Đăng nhập</h3>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4 flex flex-col md:flex-row md:items-center">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2 md:w-1/3 md:text-right md:pr-4">
                    Email:
                </label>
                <div class="md:w-2/3">
                    <input type="text" id="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative"
                            role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-4 flex flex-col md:flex-row md:items-center">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2 md:w-1/3 md:text-right md:pr-4">
                    Mật khẩu:
                </label>
                <div class="md:w-2/3">
                    <input type="password" id="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500"
                        name="password">
                    @error('password')
                        <div class="mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative"
                            role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-4 flex flex-col md:flex-row md:items-center">
                <span class="md:w-1/3"></span>
                <div class="md:w-2/3">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Duy trì đăng nhập') }}</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    name="user_register">
                    Đăng nhập
                </button>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-4 space-y-2 sm:space-y-0">
                @if (Route::has('password.request'))
                    <a class="underline text-md text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                @endif

                <a class="text-md text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center bg-gray-200 p-2" 
                href="{{ route('client.google.redirect') }}">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.0003 4.75C14.0263 4.75 15.8473 5.438 17.2403 6.818L20.0483 4.01C18.0053 1.967 15.2503 0.75 12.0003 0.75C7.93031 0.75 4.34031 3.066 2.66431 6.204L5.56031 8.528C6.38731 6.56 9.04331 4.75 12.0003 4.75Z"
                            fill="#EA4335" />
                        <path
                            d="M23.25 12.0003C23.25 11.1543 23.181 10.3343 23.044 9.54731H12V14.4753H18.472C18.18 16.0123 17.266 17.3453 16.002 18.2983V21.1073H20.048C22.316 19.0473 23.25 15.9223 23.25 12.0003Z"
                            fill="#4285F4" />
                        <path
                            d="M5.56031 15.4723C5.32831 14.7763 5.19431 14.0043 5.19431 12.9993C5.19431 11.9953 5.32831 11.2233 5.56031 10.5273L2.66431 8.20331C1.84431 9.87331 1.34031 11.8383 1.34031 12.9993C1.34031 14.1603 1.84431 16.1253 2.66431 17.7953L5.56031 15.4723Z"
                            fill="#FBBC05" />
                        <path
                            d="M12.0003 23.25C15.2503 23.25 18.0053 22.033 20.0483 19.99L16.0023 16.002C17.2663 17.345 18.1803 18.678 18.4723 20.215H12.0003V23.25Z"
                            fill="#34A853" />
                    </svg>
                    {{ __('Hoặc đăng nhập bằng tài khoản Google?') }}
                </a>
            </div>
        </form>
    </div>
@endsection
