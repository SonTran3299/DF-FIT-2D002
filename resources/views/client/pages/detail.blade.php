@extends('client.layout.master')
@section('custom-style')
    {{-- <style>
        .rating-stars i {
            cursor: pointer;
            font-size: 24px;
            margin-right: 2px;
            color: #ccc;
            transition: color 0.2s;
        }

        /* Khi một sao được hover hoặc đã được chọn */
        .rating-stars i.selected,
        .rating-stars i:hover,
        .rating-stars i.active,
        .active-stars {
            color: orange;
        }

        .rating-stars i:hover~i {
            color: #ccc;
        }
    </style> --}}
@endsection
@section('nav-other-pages')
    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
        id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
        @include('client.blocks.side-bar')
    </nav>
@endsection

@section('page-header')
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Chi tiết sản phẩm</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('client.home') }}">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Chi tiết sản phẩm</p>
            </div>
        </div>
    </div>
@endsection

@section('main-content')
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset("images/product/main_image/$data->main_image") }}"
                                alt="Image">
                        </div>
                        @php
                            $totalImages = 1 + $productImages->count();
                        @endphp
                        @if ($productImages->isNotEmpty())
                            @foreach ($productImages as $image)
                                <div class="carousel-item">
                                    <img class="w-100 h-100"
                                        src="{{ asset('images/product/product_image/' . $image->image) }}" alt="Image">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if ($totalImages > 1)
                        <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $data->name }}</h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        @php
                            $fullStars = floor($averageRating);
                            $halfStar = $averageRating - $fullStars >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;
                        @endphp
                        @for ($i = 0; $i < $fullStars; $i++)
                            <small class="fas fa-star active-stars"></small>
                        @endfor
                        @if ($halfStar)
                            <small class="fas fa-star-half-alt active-stars"></small>
                        @endif
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <small class="far fa-star"></small>
                        @endfor
                    </div>
                    <small class="pt-1">({{ $comments->count() }} đánh giá)</small>
                </div>
                <div class="mb-4">
                    @php
                        $reducePrice = $data->price * (1 - $data->discount_percentage);
                    @endphp
                    <span class="h3 text-danger font-weight-bold mr-2">{{ Number::currency($reducePrice) }}</span>
                    <span class="font-weight-semi-bold"><del>{{ Number::currency($data->price) }}</del></span>
                </div>
                <div class="mb-4">
                    <span class="h4 mr-2">Còn: </span>
                    <span class="font-weight-bold">{{ $data->stock }} sản phẩm</span>
                </div>
                {{-- size --}}
                {{-- <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-1" name="size">
                            <label class="custom-control-label" for="size-1">XS</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-2" name="size">
                            <label class="custom-control-label" for="size-2">S</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-3" name="size">
                            <label class="custom-control-label" for="size-3">M</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-4" name="size">
                            <label class="custom-control-label" for="size-4">L</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-5" name="size">
                            <label class="custom-control-label" for="size-5">XL</label>
                        </div>
                    </form>
                </div> --}}
                {{-- color --}}
                {{-- <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-1" name="color">
                            <label class="custom-control-label" for="color-1">Black</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-2" name="color">
                            <label class="custom-control-label" for="color-2">White</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-3" name="color">
                            <label class="custom-control-label" for="color-3">Red</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-4" name="color">
                            <label class="custom-control-label" for="color-4">Blue</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-5" name="color">
                            <label class="custom-control-label" for="color-5">Green</label>
                        </div>
                    </form>
                </div> --}}
                <form action="{{ route('client.add-to-cart-from-detail', ['product' => $data->id]) }}" method="post">
                    @csrf
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary text-center" name="quantity"
                                id="quantityInput" value="1" step="1" data-stock="{{ $data->stock }}">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-3" id="addToCartButton">
                            <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ
                        </button>
                    </div>
                    @if ($data->stock <= 0)
                        <p class="text-danger mt-2">Sản phẩm hiện đã hết hàng.</p>
                    @elseif($data->stock < 1)
                        <p class="text-warning mt-2">Sản phẩm sắp hết hàng (còn {{ $data->stock }} sản phẩm).</p>
                    @endif
                    <p id="stockWarning" class="text-danger mt-2" style="display: none;">Số lượng bạn chọn vượt quá số lượng
                        tồn kho.</p>
                </form>
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Chia sẻ:</p>
                    <div class="d-inline-flex">
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
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Chi tiết sản phẩm</a>
                    {{-- <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Mô tả sản phẩm</a> --}}
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh giá
                        ({{ $comments->count() }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Chi tiết sản phẩm</h4>
                        {!! $data->description !!}
                    </div>

                    {{-- <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Mô tả sản phẩm</h4>
                        {{ $data->description }}
                    </div> --}}
                    {{-- Comment --}}
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ $comments->count() }} đánh giá cho sản phẩm
                                    "{{ $data->name }}"</h4>
                                @foreach ($comments as $comment)
                                    <div class="media mb-4">
                                        <img src="{{ asset('client_asset/img/user.jpg') }}" alt="Image"
                                            class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>{{ $comment->user->name }}<small> -
                                                    <i>{{ \Carbon\Carbon::parse($comment->updated_at)->format('d-m-Y') }}</i></small>
                                            </h6>
                                            <div class="text-primary mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $comment->stars)
                                                        <i class="fas fa-star active-stars"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p>{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @if (Auth::check() && !$userHasCommented)
                                    <h4 class="mb-4">Đánh giá sản phẩm</h4>
                                    <form action="{{ route('client.comment', ['product' => $data->id]) }}"
                                        method="post">
                                        @csrf
                                        <div class="d-flex my-3">
                                            <p class="mb-0 mr-2">Chất lượng sản phẩm :</p>
                                            <div class="text-primary rating-stars" data-rating="0">
                                                <i class="far fa-star" data-star="1"></i>
                                                <i class="far fa-star" data-star="2"></i>
                                                <i class="far fa-star" data-star="3"></i>
                                                <i class="far fa-star" data-star="4"></i>
                                                <i class="far fa-star" data-star="5"></i>
                                                <input type="hidden" name="rating" id="selected-rating"
                                                    value="0">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Chia sẻ ý kiến của bạn</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control" style="resize: none;" name="comment"></textarea>
                                        </div>
                                        <div class="form-group mb-0">
                                            <button type="submit" value="Leave Your Review"
                                                class="btn btn-primary px-3">
                                                Gửi
                                            </button>
                                        </div>
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Giới thiệu thêm -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Có Thể Bạn Cũng Thích</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($products as $product)
                        <div class="card product-item border-0">
                            <div
                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100"
                                    src="{{ asset('images/product/main_image/' . $product->main_image) }}"
                                    alt="">
                                @if ($product->discount_percentage > 0)
                                    <span class="badge badge-danger position-absolute mt-2 mr-2"
                                        style="top: 0; right: 0; z-index: 10;">
                                        {{ round($product->discount_percentage * 100) }}%
                                    </span>
                                @endif
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                                <div class="d-flex justify-content-center">
                                    @php
                                        $reducePrice = $product->price * (1 - $product->discount_percentage);
                                    @endphp
                                    <h6>{{ Number::currency($reducePrice) }}</h6>
                                    <h6 class="text-muted ml-2"><del>{{ Number::currency($product->price) }}</del></h6>
                                </div>
                            </div>
                            @include('client.blocks.product-button', ['id' => $product->id])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection
@section('my-js')
    <script>
        $(document).ready(function() {
            var quantityInput = $('#quantityInput');
            var addToCartButton = $('#addToCartButton');
            var stockWarning = $('#stockWarning');
            var maxStock = parseInt(quantityInput.data('stock'));

            function checkStock() {
                var currentQuantity = parseInt(quantityInput.val());

                if (maxStock <= 0) {
                    addToCartButton.prop('disabled', true);
                    stockWarning.text('Sản phẩm hiện đã hết hàng.').show();
                    quantityInput.val(0);
                    quantityInput.prop('disabled', true);
                    $('.btn-minus, .btn-plus').prop('disabled', true);
                    return;
                }

                if (currentQuantity < 1) {
                    quantityInput.val(1);
                    currentQuantity = 1;
                }

                if (currentQuantity > maxStock) {
                    addToCartButton.prop('disabled', true);
                    stockWarning.text('Số lượng bạn chọn vượt quá số lượng tồn kho hiện có (' + maxStock + ').')
                        .show();
                } else {
                    addToCartButton.prop('disabled', false);
                    stockWarning.hide();
                }
            }

            checkStock();
            quantityInput.on('change keyup', function() {
                checkStock();
            });

            $('.btn-minus').on('click', function() {
                var value = parseInt(quantityInput.val());
                if (value > 1) {
                    quantityInput.val(value - 1);
                }
                checkStock();
            });

            $('.btn-plus').on('click', function() {
                var value = parseInt(quantityInput.val());
                if (value < maxStock) {
                    quantityInput.val(value + 1);
                } else {
                    quantityInput.val(maxStock);
                    stockWarning.text('Số lượng không thể vượt quá số lượng tồn kho hiện có (' + maxStock +
                        ').').show();
                }
                checkStock();
            });


            // Đánh giá
            const $ratingStarsContainer = $('.rating-stars');
            const $hiddenRatingInput = $('#selected-rating');

            // Hiển thị số sao đã chọn
            function updateStarDisplay(rating) {
                $ratingStarsContainer.find('i').each(function() {
                    const starValue = $(this).data('star');
                    if (starValue <= rating) {
                        $(this).removeClass('far fa-star').addClass(
                            'fas fa-star selected');
                    } else {
                        $(this).removeClass('fas fa-star selected').addClass('far fa-star');
                    }
                });
            }

            // Gọi đánh giá ban đầu
            updateStarDisplay(parseInt($hiddenRatingInput.val() || 0));

            // Sự kiện hover
            $ratingStarsContainer.find('i').on('mouseover', function() {
                const hoverValue = $(this).data('star');
                $ratingStarsContainer.find('i').each(function() {
                    if ($(this).data('star') <= hoverValue) {
                        $(this).removeClass('far fa-star').addClass(
                            'fas fa-star active');
                    } else {
                        $(this).removeClass('fas fa-star active').addClass('far fa-star');
                    }
                });
            });

            $ratingStarsContainer.find('i').on('mouseout', function() {
                updateStarDisplay(parseInt($hiddenRatingInput.val()));
            });

            // Xử lý sự kiện click (chọn sao)
            $ratingStarsContainer.find('i').on('click', function() {
                const clickedValue = $(this).data('star');
                $hiddenRatingInput.val(clickedValue);
                updateStarDisplay(clickedValue);
                console.log("Sao", clickedValue);
            });
        });
    </script>
@endsection
