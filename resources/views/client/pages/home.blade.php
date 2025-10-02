@extends('client.layout.master')

@section('nav-homepage')
    <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
        id="navbar-vertical">
        @include('client.blocks.side-bar')
    </nav>
@endsection

@section('header-carousel')
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 410px;">
                <img class="img-fluid" src="{{ asset('client_asset/img/carousel-1.jpg') }}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">Sách nổi bật trong tháng</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Sách</h3>
                        <a href="{{ route('client.shop') }}" class="btn btn-light py-2 px-3">Mua ngay</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="height: 410px;">
                <img class="img-fluid" src="{{ asset('client_asset/img/carousel-2.jpg') }}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">Ưu đãi tháng 8</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Giá ưu đãi bất ngờ</h3>
                        <a href="{{ route('client.shop') }}" class="btn btn-light py-2 px-3">Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
@endsection

@section('page-header')
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Sản phẩm chất lượng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Giao hàng nhanh chóng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Trả hàng trong vòng 7 ngày</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main-content')
    <!-- Danh mục hàng demo -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            @foreach ($categoryDemo as $data)
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4 h-100" style="padding: 30px;">
                        <div class="category-top-content d-flex flex-column align-items-center justify-content-center mb-3"
                            style="min-height: 180px;">
                            <p class="mb-2">
                                @if (array_key_exists($data->id, $productCounts))
                                    {{ $productCounts[$data->id] }} sản phẩm
                                @else
                                    0 sản phẩm
                                @endif
                            </p>
                            <form action="{{ route('client.shop') }}" method="get" class="w-100 text-center">
                                <button type="submit" class="btn cat-img position-relative overflow-hidden mb-3"
                                    style="height: 240px; width: 240px; padding: 0">
                                    <input type="hidden" name="category" value="{{ $data->slug }}">
                                    <img class="img-fluid h-100 w-100" style="object-fit: cover;"
                                        src="{{ $data->image !== null ? asset("images/category/$data->image") : asset('client_asset/img/cat-demo.png') }}"
                                        alt="{{ $data->name }}">
                                </button>
                            </form>
                        </div>

                        <h5 class="font-weight-semi-bold m-0 text-truncate-single-line text-center">
                            {{ Str::title($data->name) }}
                        </h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!----------------------->

    <!-- Ưu đãi -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="{{ asset('client_asset/img/cat-demo.png') }}" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">Giảm giá 5%</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Sách nổi bật trong tuần</h1>
                        {{-- <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="{{ asset('client_asset/img/cat-demo.png') }}" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">Giảm giá 5%</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Sách nhiều người mua</h1>
                        {{-- <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------->

    <!-- Sản phẩm nổi bật -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm ưu đãi</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($outstandingProducts as $data)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    @include('client.blocks.product-card', ['datas' => $data])
                </div>
            @endforeach
        </div>
    </div>
    <!----------------------->

    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. At provident quidem quae dolorum commodi? Corporis
                doloribus vitae nisi sed provident vel esse. Quae accusantium tempore repellat et quod sequi exercitationem!
                {{-- <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo
                        labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Nhập Email Của bạn">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Đăng ký ngay</button>
                        </div>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
    <!-- Subscribe End -->

    <!-- Sản phẩm mới -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($newProduct as $data)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    @include('client.blocks.product-card', ['datas' => $data])
                </div>
            @endforeach
        </div>
    </div>
    <!----------------------->


    <!-- Nhà cung cấp -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @for ($i = 1; $i <= 8; $i++)
                        <div class="vendor-item border p-4">
                            <img src="{{ asset("client_asset/img/vendor-$i.jpg") }}" alt="">
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <!----------------------->

    {{-- toast --}}
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-end align-items-end"
        style="min-height: 100px; position: fixed; bottom: 20px; right: 20px; z-index: 1;">
        <div class="toast" role="alert" data-delay="3000">
            <div class="toast-header">
                {{-- <img src="..." class="rounded mr-2" alt="..."> --}}
                <strong class="mr-auto">Thông báo</strong>
                {{-- <small>11 mins ago</small> --}}
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Thêm sản phẩm thành công
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script src="{{ asset('client_asset/js/addToCart.js') }}"></script>
@endsection
