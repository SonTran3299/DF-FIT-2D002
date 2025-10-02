@extends('client.layout.user')

@section('main_content')
    <div class="bg-gray-100 p-4 border-b border-gray-200 rounded-t-lg">
        <h3 class="text-xl font-semibold text-gray-800">Đăng ký</h3>
    </div>
    <div class="p-6">
        <div class="max-w-lg mx-auto">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4 flex flex-col md:flex-row md:items-center">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2 md:w-1/3 md:text-right md:pr-4">
                        Tên người dùng:
                    </label>
                    <div class="md:w-2/3">
                        <input type="text" id="name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500"
                            name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative"
                                role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

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
                    <label for="password_confirmation"
                        class="block text-gray-700 text-sm font-bold mb-2 md:w-1/3 md:text-right md:pr-4">
                        Nhập lại mật khẩu:
                    </label>
                    <div class="md:w-2/3">
                        <input type="password" id="password_confirmation"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500"
                            name="password_confirmation">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                <div class="flex items-center justify-end mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        name="register">
                        Đăng ký
                    </button>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between mt-4 space-y-2 sm:space-y-0">
                    <a class="underline text-md text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="">
                        Đã có tài khoản, đăng nhập ngay
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
