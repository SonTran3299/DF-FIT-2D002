@extends('admin.layout.master')

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Chi tiết danh mục sản phẩm</h3>
            </div>
            <form role="form" action="{{ route('admin.product_category.update', ['productCategory' => $data->id]) }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="main-image" class="mr-4">Ảnh</label>
                        <img src="{{ asset("images/category/$data->image") }}" alt="{{ $data->name }}" style="width:160px"
                            class="mr-4" id="current-main-image"
                            data-original-src="{{ asset("images/category/$data->image") }}">

                        <button type="button" class="btn btn-secondary" id="change-main-image-btn">
                            Đổi ảnh
                        </button>

                        <button type="button" class="btn btn-danger d-none" id="cancel-change-image-btn">
                            Hủy
                        </button>

                        <input class="d-none" type="file" class="form-control" id="image" name="image">
                    </div>
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="name">Tên danh mục sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nhập tên danh mục sản phẩm" value="{{ $data->name }}">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug"
                            value="{{ $data->slug }}">
                    </div>
                    @error('slug')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="1"
                                {{ $data->status == '1' ? 'checked' : '' }}>
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
                    <button type="submit" class="btn btn-primary" name="update_category">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('my-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#name').on('keyup', function() {
                var slug = $(this).val();

                $.ajax({
                    method: "GET", //method of form
                    url: "{{ route('admin.product_category.make_slug') }}",
                    data: {
                        slug: slug
                    },
                    success: function(response) {
                        $('#slug').val(response.slug);
                    }
                });
            });

            const changeImageBtn = $('#change-main-image-btn');
            const cancelChangeBtn = $('#cancel-change-image-btn');
            const imageInput = $('#image');
            const currentMainImage = $('#current-main-image');

            const originalImageSrc = currentMainImage.data('original-src');

            // Nhấn để chọn ảnh
            changeImageBtn.on('click', function(e) {
                e.preventDefault();
                imageInput.click();
            });

            // Chọn ảnh mới
            imageInput.on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader(); // API của trình duyệt cho phép đọc file

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

                imageInput.val('');

                cancelChangeBtn.addClass('d-none');
            });
        });
    </script>
@endsection
