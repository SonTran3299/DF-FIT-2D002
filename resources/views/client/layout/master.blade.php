<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>My Project</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    {{-- <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-url" content="{{ route('login') }}">

    <!-- Favicon -->
    <link href="{{ asset('client_asset/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('client_asset/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('client_asset/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">

    {{-- css cho card product --}}
    <link rel="stylesheet" href="{{asset('client_asset/css/card.css')}}">
    @yield('custom-style')
</head>

<body>
    <!-- Topbar -->
    @include('client.blocks.topbar')

    <!-- Navbar  -->
    @include('client.blocks.nav-bar')

    <!-- Featured/ Page Header -->
    @yield('page-header')

    <!-- content -->
    @yield('main-content')

    <!-- Footer -->
    @include('client.blocks.footer')


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('client_asset/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('client_asset/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('client_asset/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('client_asset/mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('client_asset/js/main.js') }}"></script>

    <script>
        const cartCountUrl = "{{ route('client.cart-count') }}";

        function updateCartCount() {
            fetch(cartCountUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Ensure the element exists before trying to update it
                    const cartItemCountElement = document.getElementById('cart-item-count');
                    if (cartItemCountElement) {
                        cartItemCountElement.innerText = data.count;
                        //console.log('New cart count updated globally:', data.count); // Global log
                    }
                    //else {
                    //     console.warn('Element with ID "cart-item-count" not found. Cannot update cart count.');
                    //}
                })
                .catch(error => {
                    //console.error('Error fetching cart count in global updateCartCount:', error);
                    const cartItemCountElement = document.getElementById('cart-item-count');
                    if (cartItemCountElement) {
                        cartItemCountElement.innerText = '0';
                    }
                });
        }

        $(document).ready(function() {
            if (window.isAuthenticated) {
                updateCartCount(); // Chỉ gọi khi đã đăng nhập
            }
        });
    </script>
    @yield('my-js')
</body>

</html>
