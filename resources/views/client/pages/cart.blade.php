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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Giỏ hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('client.home') }}">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Giỏ hàng</p>
            </div>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            @if (!empty($cart) && count($cart) > 0)
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-bordered text-center mb-0" style="table-layout: fixed; width:100%">
                        <thead class="bg-secondary text-dark ">
                            <tr>
                                <th style="width: 100px">Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th style="width: 120px;">Giá</th>
                                <th>Số lượng</th>
                                <th>Tạm tính</th>
                                <th style="width: 90px;">Chiết khấu</th>
                                <th style="width: 60px;">Xoá</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @php $totalPrice = 0 @endphp
                            @foreach ($cart as $data)
                                <tr class="cart-item-row cart-item-row {{ $data->product && $data->product->status !== 0 ? 'active-cart-item' : 'inactive-cart-item' }}"
                                    data-cart-id="{{ $data->id }}">
                                    <td class="align-middle text-left">
                                        <img src="{{ asset('images/product/main_image/' . $data->product->main_image) }}"
                                            alt="{{ $data->product->name }}" style="width: 50px;">
                                    </td>
                                    <td class="align-middle text-left">
                                        {{ $data->product->name }}
                                    </td>
                                    <td class="align-middle product-price" data-price="{{ $data->product->price }}">
                                        {{ Number::currency($data->product->price) }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus-cart" type="button">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="product_quantity"
                                                class="form-control form-control-sm bg-secondary text-center quantity-input-cart"
                                                value="{{ $data->quantity }}" data-stock="{{ $data->product->stock }}"
                                                data-cart-item-id="{{ $data->id }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus-cart" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small class="text-danger item-stock-warning" style="display: none;"></small>
                                    </td>
                                    @php
                                        $subTotal = $data->quantity * $data->product->price;
                                        $totalPrice += $subTotal;
                                    @endphp
                                    <td class="align-middle item-subtotal">{{ Number::currency($subTotal) }}</td>
                                    <td class="align-middle" data-discount="{{ $data->product->discount_percentage }}">
                                        {{ $data->product->discount_percentage * 100 }}%</td>
                                    <td class="align-middle">
                                        <form action="{{ route('client.delete-product', ['product' => $data->id]) }}"
                                            method="post">
                                            @csrf
                                            <button class="btn btn-sm btn-primary"
                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm ra khỏi giỏ hàng không?')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    {{-- chưa --}}
                    <form class="mb-5" action="">
                        <div class="input-group">
                            <input type="text" class="form-control p-4" placeholder="Mã giảm giá">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Thêm mã giảm giá</button>
                            </div>
                        </div>
                    </form>

                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Tạm tính</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Tổng tiền</h6>
                                <h6 class="font-weight-medium cart-subtotal" id="cartSubtotal">
                                    {{ Number::currency($caculatePrice['subtotal']) }}</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Giảm giá</h6>
                                <h6 class="font-weight-medium cart-subtotal text-danger font-italic" id="cartDiscount">
                                    {{ Number::currency($caculatePrice['discount']) }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Phí vận chuyển</h6>
                                <h6 class="font-weight-medium" id="shippingFee"
                                    data-shipping-fee="{{ $caculatePrice['shippingFee'] }}">
                                    {{ Number::currency($caculatePrice['shippingFee']) }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Tổng cộng</h5>
                                <h5 class="font-weight-bold" id="cartTotal">
                                    {{ Number::currency($caculatePrice['total']) }}
                                </h5>
                            </div>
                            <form action="{{ route('client.update-cart') }}" method="post" id="updateCartForm">
                                @csrf
                                <input type="hidden" name="cart_items_data" id="cartItemsData">
                                <button type="submit" form="updateCartForm" class="btn btn-block btn-success my-3 py-3"
                                    style="font-size: 18px">
                                    Tiến hành thanh toán
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @else
                <div class="col-12 text-center">
                    <h4 class="text-danger font-weight-bold">Giỏ hàng rỗng, hãy tiếp tục mua sắm</h4>
                </div>
            @endif
            @if ($unactiveItemCount !== 0)
                <div class="row">
                    <div class="col-lg-8 table-responsive mb-5">
                        <h3>Có {{ $unactiveItemCount }} sản phẩm hết hàng trong giỏ</h3>
                        <table class="table table-bordered text-center mb-0" style="table-layout: fixed; width:100%">
                            <tbody class="align-middle">
                                @php $totalPrice = 0 @endphp
                                @foreach ($unactiveCartItems as $data)
                                    <tr>
                                        <td class="align-middle text-left">
                                            <img src="{{ asset('images/product/main_image/' . $data->product->main_image) }}"
                                                alt="{{ $data->product->name }}" style="width: 50px;">
                                        </td>
                                        <td class="align-middle text-left">
                                            {{ $data->product->name }}
                                        </td>
                                        <td class="align-middle">
                                            {{ Number::currency($data->product->price) }}
                                        </td>
                                        <td class="align-middle">
                                            <form action="{{ route('client.delete-product', ['product' => $data->id]) }}"
                                                method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm ra khỏi giỏ hàng không?')">
                                                    Bỏ khỏi giỏ hàng</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('my-js')
    <script>
        $(document).ready(function() {
            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(amount);
            }

            var initialShippingFee = parseFloat($('#shippingFee').data('shipping-fee'));
            if (isNaN(initialShippingFee)) {
                initialShippingFee = 0;
            }

            function updateItemSubtotal(row) {
                var quantityInput = row.find('.quantity-input-cart');
                var priceElement = row.find('.product-price');
                var itemSubtotalElement = row.find('.item-subtotal');
                var itemStockWarning = row.find('.item-stock-warning');
                var currentQuantity = parseInt(quantityInput.val());
                var productPrice = parseFloat(priceElement.data('price'));
                var maxStock = parseInt(quantityInput.data('stock'));

                if (currentQuantity < 1) {
                    quantityInput.val(1);
                    currentQuantity = 1;
                }

                if (currentQuantity > maxStock) {
                    quantityInput.val(maxStock);
                    currentQuantity = maxStock;
                    itemStockWarning.text('Số lượng không thể vượt quá số lượng tồn kho hiện có (' + maxStock +
                        ').').show();
                } else if (maxStock <= 0) {
                    quantityInput.val(0);
                    currentQuantity = 0;
                    quantityInput.prop('disabled', true);
                    row.find('.btn-minus-cart, .btn-plus-cart').prop('disabled', true);
                    itemStockWarning.text('Sản phẩm hiện đã hết hàng.').show();
                } else {
                    itemStockWarning.hide();
                }

                var newSubtotal = currentQuantity * productPrice;
                itemSubtotalElement.text(formatCurrency(newSubtotal));

                updateCartTotals();
            }

            function updateCartTotals() {
                var overallSubtotal = 0;
                var totalDiscountAmount = 0;

                $('.cart-item-row').each(function() {
                    var row = $(this);
                    var quantity = parseInt(row.find('.quantity-input-cart').val());
                    var price = parseFloat(row.find('.product-price').data('price'));
                    var discountPercentage = parseFloat(row.find('[data-discount]').data('discount'));

                    // Tính tạm tính của sản phẩm này (trước chiết khấu)
                    var itemBasePrice = quantity * price;
                    overallSubtotal += itemBasePrice;

                    // Tính số tiền chiết khấu cho sản phẩm này
                    var itemDiscount = itemBasePrice * discountPercentage;
                    totalDiscountAmount += itemDiscount;
                });

                // Cập nhật tạm tính chưa chiết khấu
                $('#cartSubtotal').text(formatCurrency(overallSubtotal));

                // Tính phí vận chuyển
                var currentShippingFee = initialShippingFee;
                if (overallSubtotal > 500000) {
                    currentShippingFee = 0;
                }
                $('#shippingFee').text(formatCurrency(currentShippingFee));

                // Cập nhật tổng giảm giá
                $('#cartDiscount').text(formatCurrency(totalDiscountAmount));

                var finalTotal = overallSubtotal - totalDiscountAmount + currentShippingFee;
                $('#cartTotal').text(formatCurrency(finalTotal));
            }

            $('.cart-item-row').each(function() {
                updateItemSubtotal($(this));
            });
            updateCartTotals();

            $('.quantity-input-cart').on('change keyup', function() {
                var row = $(this).closest('.cart-item-row');
                updateItemSubtotal(row);
            });

            $('.btn-minus-cart').on('click', function() {
                var row = $(this).closest('.cart-item-row');
                var quantityInput = row.find('.quantity-input-cart');
                var currentValue = parseInt(quantityInput.val());
                if (currentValue > 1) {
                    quantityInput.val(currentValue - 1);
                }
                updateItemSubtotal(row);
            });

            $('.btn-plus-cart').on('click', function() {
                var row = $(this).closest('.cart-item-row');
                var quantityInput = row.find('.quantity-input-cart');
                var currentValue = parseInt(quantityInput.val());
                var maxStock = parseInt(quantityInput.data('stock'));

                if (currentValue < maxStock) {
                    quantityInput.val(currentValue + 1);
                } else {
                    quantityInput.val(maxStock);
                    row.find('.item-stock-warning').text(
                            'Số lượng không thể vượt quá số lượng tồn kho hiện có (' + maxStock + ').')
                        .show();
                }
                updateItemSubtotal(row);
            });

            $('#updateCartForm').on('submit', function(e) {
                var cartItems = [];
                $('.quantity-input-cart').each(function() {
                    var cartItemId = $(this).data('cart-item-id');
                    var quantity = parseInt($(this).val());

                    // Chỉ thêm vào nếu có ID và số lượng hợp lệ
                    if (cartItemId && !isNaN(quantity)) {
                        cartItems.push({
                            id: cartItemId,
                            quantity: quantity
                        });
                    }
                });
                $('#cartItemsData').val(JSON.stringify(cartItems));
            });
        });
    </script>
@endsection
