@extends('client.layout.master')

@section('nav-other-pages')
    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
        id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
        @include('client.blocks.side-bar')
    </nav>
@endsection

@section('page-header')
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Liên hệ với chúng tôi</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('client.home') }}">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Liên hệ</p>
            </div>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Liên hệ để được giải đáp mọi thắc mắc</span></h2>
            <h3>{{ session('msg') }}</h3>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form action="{{ route('client.receive-message') }}" method="POST">
                        @csrf
                        <div class="control-group mb-2">
                            <input type="text" class="form-control" id="name" placeholder="Tên" name="name"
                                required="required" />
                        </div>
                        <div class="control-group mb-2">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                                required="required" />
                        </div>
                        <div class="control-group mb-2">
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Thêm số điện thoại liên hệ" required="required" />
                        </div>
                        <div class="control-group mb-2">
                            <textarea class="form-control" rows="6" id="message" name="message" placeholder="Nội dung" required="required"
                                style="resize: none"></textarea>
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">
                                Gửi thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold mb-3">Liên hệ</h5>
                <p>Quý khách có thể liên hệ trực tiếp qua zalo hoặc số điện thoại chăm sóc khách hàng.</p>
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-semi-bold mb-3">Cửa hàng</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Đường 123, phường 456, TP HCM
                    </p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>012 345 6789</p>
                </div>
            </div>
        </div>
    </div>
@endsection
