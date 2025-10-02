<div class="card product-item border-0 mb-4">
    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
        <img class="img-fluid w-100 product-image-fixed-size"
            src="{{ $data->main_image !== null ? asset("images/product/main_image/$data->main_image") : asset('images/product/default-product-image.jpg') }}"
            alt="{{ $data->name }}">
        @if ($data->discount_percentage > 0)
            <span class="badge badge-danger position-absolute mt-2 mr-2" style="top: 0; right: 0; z-index: 10;">
                {{ round($data->discount_percentage * 100) }}%
            </span>
        @endif
    </div>
    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
        <h6 class="text-truncate mb-3">{{ $data->name }}</h6>
        <div class="d-flex justify-content-center">
            @php
                $reducePrice = $data->price * (1 - $data->discount_percentage);
            @endphp
            <h5 class="text-danger font-weight-bold">{{ Number::currency($reducePrice) }}</h5>
            <h6 class="text-muted font-italic ml-2"><del>{{ Number::currency($data->price) }}</del></h6>
        </div>
    </div>
    @include('client.blocks.product-button', ['id' => $data->id])
</div>