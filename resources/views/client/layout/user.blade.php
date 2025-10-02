<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="dns-prefetch" href="[https://fonts.gstatic.com](https://fonts.gstatic.com)">
    <link
        href="[https://fonts.googleapis.com/css?family=Raleway:300,400,600](https://fonts.googleapis.com/css?family=Raleway:300,400,600)"
        rel="stylesheet" type="text/css">
    <link rel="preconnect" href="[https://fonts.bunny.net](https://fonts.bunny.net)">
    <link
        href="[https://fonts.bunny.net/css?family=instrument-sans:400,500,600](https://fonts.bunny.net/css?family=instrument-sans:400,500,600)"
        rel="stylesheet" />
    <link rel="icon" href="Favicon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>My Project</title>
</head>

<body>
    <nav class="bg-white shadow py-4">
        <div class="container mx-auto px-4 flex flex-wrap items-center justify-between">
            <a class="text-xl font-semibold text-gray-800" href="">Trang chủ</a>
            <button
                class="block lg:hidden px-3 py-2 rounded text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M4 5h16a1 1 0 010 2H4a1 1 0 110-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2zm0 6h16a1 1 0 010 2H4a1 1 0 010-2z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <div class="hidden lg:flex lg:flex-grow lg:items-center" id="navbarSupportedContent">
                <ul class="flex flex-col lg:flex-row lg:ml-auto">
                    <li class="py-2 lg:py-0 lg:px-2">
                        <a class="block text-gray-700 hover:text-gray-900" href="">Đăng
                            nhập</a>
                    </li>
                    <li class="py-2 lg:py-0 lg:px-2">
                        <a class="block text-gray-700 hover:text-gray-900" href="">Đăng
                            ký</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 mt-4">
        <div class="flex flex-wrap justify-center">
            <div class="w-full md:w-8/12 px-4">
                <div class="bg-white shadow-md rounded-lg p-6">
                    @yield('main_content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>
