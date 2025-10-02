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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Lịch sử đơn hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('client.home') }}">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Lịch sử đơn hàng</p>
            </div>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="container-fluid pt-5">
        <div class="accordion" id="accordionExample">
            @foreach ($dataOrder as $order)
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseControl{{ $loop->iteration }}"
                                        aria-expanded="false" aria-controls="collapseControl{{ $loop->iteration }}"
                                        style="font-size: 18px;">
                                        Đơn hàng #{{ $order->id }}
                                    </button>
                                </div>
                                <div class="col-md-4 text-right" style="font-size: 18px;">
                                    {{ $order->status_to_text }}
                                </div>
                            </div>
                        </h2>
                    </div>
                    <div id="collapseControl{{ $loop->iteration }}" class="collapse" aria-labelledby="heading2">
                        @foreach ($order->orderItems as $orderItem)
                            @php
                                $discount = 0;
                                $discount += $orderItem->price * $orderItem->discount_percentage * $orderItem->quantity;
                            @endphp
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/product/main_image/' . $orderItem->main_image) }}"
                                        alt="{{ $orderItem->name }}" style="width: 120px; margin-right: 15px;">
                                    <div>
                                        <div>
                                            <span>Tên: </span>
                                            <span>{{ $orderItem->name }}</span>
                                        </div>
                                        <div>
                                            <span>Giá: </span>
                                            <span>{{ Number::currency($orderItem->price) }}</span>
                                        </div>
                                        <div>
                                            <span>Số lượng: </span>
                                            <span>{{ $orderItem->quantity }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-end">
                            <div class="text-left mr-2">
                                <div>
                                    <span>Tạm tính: </span>
                                    <span>{{ Number::currency($order->subtotal) }}</span>
                                </div>
                                <div>
                                    <span>Giảm giá: </span>
                                    <span>{{ Number::currency($discount) }}</span>
                                </div>
                                <div>
                                    <span>Phí giao hàng: </span>
                                    <span>{{ Number::currency($order->shipping_fee) }}</span>
                                </div>
                                <div>
                                    <span>Tổng cộng: </span>
                                    <span>{{ Number::currency($order->total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
