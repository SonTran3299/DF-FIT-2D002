@extends('admin.layout.master')

@section('content')
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3>
                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                </h3>
                <h3 class="card-title">Thông tin đơn hàng</h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <span>Mã đơn hàng:</span>
                            <span class="text-danger">{{ $data->id }}</span>
                        </div>

                        <div>
                            <span>Trạng thái:</span>
                            <span class="text-danger">{{ $data->status_to_text }}</span>
                        </div>
                    </div>
                    <hr class="my-3" style="border-top: 1px solid #eee;">

                    <div class="class=col-md-6">
                        <div>
                            <span>Ngày đặt đơn hàng:</span>
                            <span
                                class="text-danger">{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                        <div>
                            <span>Thời gian xử lý đơn hàng:</span>
                            <span
                                class="text-danger">{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                    </div>

                </div>
                <hr class="my-3" style="border-top: 1px solid #eee;">
                <div>
                    <span>Tên khách hàng: {{ $data->user->name }}</span>
                </div>
                <div>
                    <span>Số điện thoại nhận hàng: {{ $data->user->phone }}</span>
                </div>
                <div class="mb-3">
                    <span>Địa chỉ nhận hàng: {{ $data->address }}</span>
                </div>


                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Giảm giá</th>
                            <th>Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->orderItems as $orderItem)
                            @php

                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('images/product/main_image/' . $orderItem->main_image) }}"
                                        style="width:160px" alt="{{ $orderItem->name }}">
                                </td>
                                <td>{{ $orderItem->name }}</td>
                                <td>{{ Number::currency($orderItem->price) }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                                <td>
                                    giảm giá
                                </td>
                                <td>{{ Number::currency($orderItem->price * $orderItem->quantity) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end w-100">
                    <div class="d-flex flex-column mr-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="mr-1 font-weight-bold">Tạm tính: </span>
                            <span>{{ Number::currency($data->subtotal) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="mr-1 font-weight-bold">Phí giao hàng: </span>
                            <span>{{ Number::currency($data->shipping_fee) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="mr-1 font-weight-bold">Tổng: </span>
                            <span>{{ Number::currency($data->total) }}</span>
                        </div>
                    </div>
                </div>
                @if ($data->status !== 4)
                    <form class="ml-3" action="{{ route('admin.order.update-order-status', ['order' => $data->id]) }}"
                        method="post">
                        @csrf
                        @if ($data->status === 0)
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-success">Xác nhận</button>
                        @else
                            @if ($data->status === 1)
                                <input type="hidden" name="status" value="2">
                                <button type="submit" class="btn btn-success">Giao hàng</button>
                            @else
                                @if ($data->status === 2)
                                    <input type="hidden" name="status" value="3">
                                    <button type="submit" class="btn btn-success">Giao hàng thành công</button>
                                @endif
                            @endif
                        @endif
                        @if ($data->status === 2)
                            <input type="hidden" name="status" value="5">
                            <button type="submit" class="btn btn-danger">Giao hàng thất bại</button>
                        @endif
                    </form>
                @endif
            </div>
        </div>
    @endsection
