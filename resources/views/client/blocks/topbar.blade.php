<div class="container-fluid">
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="{{ route('client.contact') }}">Liên hệ</a>
                {{-- <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Liên hệ</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Support</a> --}}
            </div>
        </div>
        {{-- <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark px-2" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-dark pl-2" href="">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div> --}}
    </div>
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="{{ route('client.home') }}" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span
                        class="text-primary font-weight-bold border px-3 mr-1">S</span>Shopper</h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <form action="{{ route('client.shop') }}" method="get" id="search-form">
                <div class="input-group">
                    <input type="text" class="form-control" name="query"
                        value="{{ request()->get('query') ?? '' }}" placeholder="Tìm kiếm sản phẩm">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-3 col-6 ml-auto">
            <div class="row align-items-center justify-content-end">
                <div class="py-0">
                    @auth
                        <div class="dropdown d-inline-block">
                            <a href="#" class="nav-link dropdown-toggle text-primary"
                                data-toggle="dropdown">{{ Auth::user()->name }}</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                @if (Auth::user()->role)
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        Dành cho Admin
                                    </a>
                                @else
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                        Hồ sơ người dùng
                                    </a>
                                    <a href="{{ route('client.order-history') }}" class="dropdown-item">
                                        Lịch sử đơn hàng
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                        {{ __('Đăng xuất') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="d-inline-block nav-item nav-link p-0">Đăng nhập</a>
                        <span class="text-muted px-2">|</span>
                        <a href="{{ route('register') }}" class="d-inline-block nav-item nav-link p-0">Đăng ký</a>
                    @endauth
                </div>

                {{-- <div class="{{Auth::user() }}">
                    <a href="" class="btn border">
                        <i class="fas fa-heart text-primary"></i>
                        <span class="badge">0</span>
                    </a>
                    <a href="{{ route('client.cart') }}" class="btn border">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        <span class="badge" id="cart-item-count">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </a>
                </div> --}}
                @auth 
                    <div>
                        {{-- <a href="" class="btn border">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge">0</span>
                        </a> --}}
                        <a href="{{ route('client.cart') }}" class="btn border">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge" id="cart-item-count">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
