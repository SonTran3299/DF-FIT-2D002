@extends('admin.layout.master')

@section('content')
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Danh sách danh mục sản phẩm</h3>
            </div>

            {{-- Search --}}
            @include('admin.blocks.search_form', [
                'actionFormRoute' => route('admin.product_category.list'),
                'title' => 'Thêm danh mục',
            ])

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Tình trạng</th>
                            <th>Ngày tạo</th>
                            <th>Đã xoá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->slug }}</td>
                                <td>
                                    {{ $data->status ? 'Hiện' : 'Ẩn' }}
                                </td>
                                <td>{{ $data->formatted_created_at }}</td>
                                <td>
                                    @if (!is_null($data->formatted_deleted_at))
                                        <form
                                            action="{{ route('admin.product_category.restore', ['productCategory' => $data->id]) }}"
                                            method="post">
                                            @csrf
                                            <button class="btn btn-primary">Khôi phục</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-product-category-info"
                                        data-toggle="modal" data-target="#productCategoryModal"
                                        data-product-category-id="{{ $data->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <form
                                        action="{{ route('admin.product_category.destroy', ['productCategory' => $data->id]) }}"
                                        method="post" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-danger" type="submit"
                                            onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $datas->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productCategoryModal" tabindex="-1" aria-labelledby="productCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productCategoryModalLabel">Sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form role="form" action="{{ route('admin.product_category.store') }}" method="post"
                    enctype="multipart/form-data" id="product-category-form">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div id="create-image-section" class="form-group">
                                <label for="category-image">Ảnh danh mục</label>
                                <input type="file" class="form-control" id="category-image" name="image">
                            </div>

                            <div id="edit-image-section" class="form-group d-none">
                                <label class="d-block">Ảnh hiện tại</label>
                                <div class="d-flex align-items-center">
                                    <img src="" alt="" style="width:160px" class="mr-4 img-thumbnail"
                                        id="current-main-image">

                                    <button type="button" class="btn btn-sm btn-warning mr-1"
                                        id="change-main-image-btn">Đổi
                                        ảnh</button>
                                    <button type="button" class="btn btn-sm btn-danger d-none"
                                        id="cancel-change-image-btn">Hủy</button>

                                    <input type="file" class="d-none" id="edit-image-input" name="image">
                                </div>
                            </div>

                            @error('image')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="name">Tên danh mục sản phẩm</label>
                                <input type="text" class="form-control" id="category-name" name="name"
                                    placeholder="Nhập tên danh mục sản phẩm" value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="category-slug" name="slug"
                                    placeholder="Nhập slug" value="{{ old('slug') }}">
                            </div>
                            @error('slug')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_active"
                                        value="1"
                                        {{ old('status') === '1' || old('status') === null ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_active">Hiện</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_inactive"
                                        value="0" {{ old('status') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_inactive">Ẩn</label>
                                </div>
                            </div>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="modal-submit"
                            name="create_category"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('my-js')
    @include('admin.blocks.notification')
    <script type="text/javascript">
        $(document).ready(function() {
            // const defaultImagePath = "{{ asset('images/category/default_product.svg') }}";
            // const baseImagePath = "{{ asset('images/category/') }}/";

            const imagePath = "{{ asset(App\Models\ProductCategory::IMAGE_PATH) }}/";
            const defaultImage =
                "{{ asset(App\Models\ProductCategory::IMAGE_PATH . '/' . App\Models\ProductCategory::DEFAULT_IMAGE) }}";

            $('#category-name').on('keyup', function() {
                let slug = $(this).val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.product_category.make_slug') }}",
                    data: {
                        slug: slug
                    },
                    success: function(response) {
                        $('#category-slug').val(response.slug);
                    }
                });
            });

            // Button Create
            $('#btn-create').on('click', function() {
                $('#productCategoryModalLabel').text('Tạo danh mục sản phẩm');
                $('#product-category-form').attr('action', "{{ route('admin.product_category.store') }}");
                $('#modal-submit').text('Tạo danh mục').removeClass('btn-success').addClass('btn-primary');

                $('#create-image-section').removeClass('d-none');
                $('#edit-image-section').addClass('d-none');
                $('#method_put').remove();

                $('#current-main-image').attr('src', defaultImage).data('original-src', defaultImage);
            });

            // Button Info
            $(document).on('click', '.btn-product-category-info', function() {
                let productCategoryId = $(this).data('product-category-id');

                if (!productCategoryId) {
                    alert("Vui lòng làm mới trang để xem thông tin danh mục vừa tạo!");
                    return;
                }

                let detailUrl = "{{ route('admin.product_category.detail', ':id') }}".replace(':id',
                    productCategoryId);
                let updateUrl = "{{ route('admin.product_category.update', ':id') }}".replace(':id',
                    productCategoryId);

                $('#productCategoryModalLabel').text('Chi tiết & Cập nhật danh mục');
                $('#modal-submit').text('Lưu thay đổi').removeClass('btn-primary').addClass('btn-success');
                $('#product-category-form').attr('action', updateUrl);

                $('#create-image-section').addClass('d-none');
                $('#edit-image-section').removeClass('d-none');

                if ($('#method_put').length === 0) {
                    $('#product-category-form').prepend(
                        '<input type="hidden" name="_method" value="PUT" id="method_put">');
                }

                $.ajax({
                    url: detailUrl,
                    type: 'GET',
                    success: function(data) {
                        $('#category-name').val(data.name);
                        $('#category-slug').val(data.slug);

                        //let imgSrc = data.image ? baseImagePath + data.image : defaultImagePath;
                        let imgSrc = data.image ? (imagePath + data.image) : defaultImage;

                        $('#current-main-image').attr('src', imgSrc).data('original-src',
                            imgSrc);

                        if (data.status == 1) {
                            $('#status_active').prop('checked', true);
                        } else {
                            $('#status_inactive').prop('checked', true);
                        }
                        $('#productCategoryModal').modal('show');
                    }
                });
            });

            // Change Image
            $('#change-main-image-btn').on('click', function(e) {
                e.preventDefault();
                $('#edit-image-input').click(); // Mở hộp thoại chọn file
            });

            $('#edit-image-input').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#current-main-image').attr('src', e.target.result);
                        $('#cancel-change-image-btn').removeClass('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#cancel-change-image-btn').on('click', function(e) {
                e.preventDefault();
                const originalSrc = $('#current-main-image').data('original-src');
                $('#current-main-image').attr('src', originalSrc);
                $('#image').val(''); // Xóa file đã chọn
                $(this).addClass('d-none');
            });

            // Close MODAL
            $('#productCategoryModal').on('hidden.bs.modal', function() {
                $('#product-category-form')[0].reset();
                $(this).find('.alert-danger').remove();
                $('#method_put').remove();
                $('#cancel-change-image-btn').addClass('d-none');
                $('#status_active').prop('checked', true);
                // Reset ảnh về mặc định tránh bị lưu ảnh của lần mở trước
                //$('#current-main-image').attr('src', defaultImagePath);

                $('#current-main-image').attr('src', defaultImage).data('original-src', defaultImage);
                $('#edit-image-input').val('');
            });
        });
    </script>
@endsection
