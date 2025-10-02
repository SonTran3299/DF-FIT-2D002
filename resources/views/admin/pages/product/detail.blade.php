@extends('admin.layout.master')

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Chi tiết sản phẩm</h3>
            </div>
            <form role="form" action="{{ route('admin.product.update', ['product' => $data->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="main-image" class="mr-4">Ảnh chính của sản phẩm</label>
                        <img src="{{ asset("images/product/main_image/$data->main_image") }}" alt="{{ $data->name }}"
                            style="width:160px" class="mr-4" id="current-main-image"
                            data-original-src="{{ asset("images/product/main_image/$data->main_image") }}">

                        <button type="button" class="btn btn-secondary" id="change-main-image-btn">
                            Đổi ảnh
                        </button>

                        <button type="button" class="btn btn-danger d-none" id="cancel-change-image-btn">
                            Hủy
                        </button>

                        <input class="d-none" type="file" class="form-control" id="main-image" name="main_image">
                    </div>
                    @error('main_image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    {{-- <div class="form-group">
                        <label for="image" class="mr-4">Ảnh phụ của sản phẩm</label>
                        <img src="{{ asset("images/product/product_image/$data->main_image") }}" alt="{{ $data->name }}"
                            style="width:160px" class="mr-4">
                        <button type="button" class="btn btn-secondary" id="change-main-image">
                            Đổi ảnh
                        </button>
                        <input class="d-none form-control mt-2" type="file" class="form-control" id="image"
                            name="image">
                    </div>
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}

                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nhập tên sản phẩm" value="{{ $data->name }}">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="description">Mô tả sản phẩm</label>
                        <div id="description_html"></div>
                        <input type="hidden" name="description" id="description">
                        <input type="hidden" name="old_description" id="old_description" value="{{ $data->description }}">
                    </div>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input type="number" class="form-control" id="price" name="price"
                            placeholder="Nhập giá của sản phẩm" value="{{ $data->price }}">
                    </div>
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="discount_percentage">Giảm giá sản phẩm (nếu cần)</label>
                        <input type="number" step="any" class="form-control" id="discount_percentage"
                            name="discount_percentage" placeholder="Mặc định 0%" value="{{ $data->discount_percentage }}">
                    </div>
                    @error('discount_percentage')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="stock">Tồn kho</label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            placeholder="Nhập tồn kho của sản phẩm" value="{{ $data->stock }}">
                    </div>
                    @error('stock')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="category">Danh mục sản phẩm</label>
                        <div class="form-group">
                            <select id="category" name="product_category_id" class="form-control">
                                <option value="">---Chọn---</option>
                                @foreach ($categoryList as $category)
                                    <option {{ $data->product_category_id === $category->id ? 'selected' : '' }}
                                        value="{{ $category->id }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('product_category_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Tình trạng</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_active"
                                value="1" {{ $data->status == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_active">Hiện</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_inactive"
                                value="0" {{ $data->status == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_inactive">Ẩn</label>
                        </div>
                    </div>
                    @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="update_product">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('my-js')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        const quill = new Quill('#description_html', {
            theme: 'snow'
        });

        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("description").value = quill.root.innerHTML;
        });

        const oldDescription = document.getElementById("old_description").value;
        if (oldDescription) {
            quill.clipboard.dangerouslyPasteHTML(oldDescription);
        }

        $(document).ready(function() {
            const changeImageBtn = $('#change-main-image-btn');
            const cancelChangeBtn = $('#cancel-change-image-btn');
            const mainImageInput = $('#main-image');
            const currentMainImage = $('#current-main-image');

            const originalImageSrc = currentMainImage.data('original-src');

            // Nhấn để chọn ảnh
            changeImageBtn.on('click', function(e) {
                e.preventDefault();
                $('#main-image').click();
            });

            mainImageInput.on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        currentMainImage.attr('src', e.target.result);
                        cancelChangeBtn.removeClass('d-none');
                    };

                    reader.readAsDataURL(file);
                } else {
                    currentMainImage.attr('src', originalImageSrc);
                    cancelChangeBtn.addClass('d-none');
                }
            });

            cancelChangeBtn.on('click', function(e) {
                e.preventDefault();
                currentMainImage.attr('src', originalImageSrc);

                mainImageInput.val('');

                cancelChangeBtn.addClass('d-none');
            });
        });
    </script>
@endsection
