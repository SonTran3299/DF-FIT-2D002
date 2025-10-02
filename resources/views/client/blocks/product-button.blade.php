<div class="card-footer d-flex justify-content-between bg-light border">
    <a href="{{ route('client.detail', ['product' => $id]) }}" class="btn btn-sm text-dark p-0"><i
            class="fas fa-eye text-primary mr-1"></i>
        Chi tiết
    </a>
    <button data-product="{{ $id }}" data-url="{{ route('client.add-item-to-cart', ['product' => $id]) }}"
        class="btn btn-sm text-dark p-0 add-product-to-cart"><i class="fas fa-shopping-cart text-primary mr-1"></i>
        Thêm vào giỏ
    </button>
</div>
