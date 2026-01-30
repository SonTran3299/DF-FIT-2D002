@extends('admin.layout.master')

@section('content')
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Danh sách sản phẩm</h3>
            </div>

            {{-- Search --}}
            @include('admin.blocks.search_form', [
                'actionFormRoute' => route('admin.product.list'),
                'title' => 'Thêm sản phẩm',
                'modal_target' => 'productModal',
            ])

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Tên</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Danh mục</th>
                            <th>Ngày cập nhật</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <img src="{{ asset("images/product/main_image/$data->main_image") }}" style="width:160px"
                                        alt="{{ $data->name }}">
                                </td>
                                <td>{{ Number::currency($data->price) }}</td>
                                <td>{{ $data->stock }}</td>
                                <td>
                                    {{ $data->status ? 'Đang bán' : 'Ngưng bán' }}
                                </td>
                                <td>{{ $data->productCategory?->name }}</td>
                                <td>{{ $data->formatted_updated_at }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-product-info"
                                        data-product-id="{{ $data->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @if (!is_null($data->deleted_at))
                                        <form action="{{ route('admin.product.restore', ['product' => $data->id]) }}"
                                            method="post">
                                            @csrf
                                            <button class="btn btn-primary">Khôi phục</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.product.destroy', ['product' => $data->id]) }}"
                                            method="post" class="d-inline">
                                            @csrf
                                            <button class="btn btn-outline-danger" type="submit"
                                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    @endif

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
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form role="form" action="{{ route('admin.product.store') }}" method="post"
                    enctype="multipart/form-data" id="product-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="card-body">
                            <div id="create-image-section" class="form-group">
                                <label for="main-product-image">Ảnh sản phẩm</label>
                                <input type="file" class="form-control" id="main-product-image" name="main_image">
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

                                    <input type="file" class="d-none" id="edit-image-input" name="main_image">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="product-name" name="name"
                                    placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <div id="description_html"></div>
                                <input type="hidden" name="description" id="product-description">
                                <input type="hidden" name="old_description" id="old_description"
                                    value="{{ old('description') }}">
                            </div>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="number" class="form-control" id="product-price" name="price"
                                    placeholder="Nhập giá của sản phẩm" value="{{ old('price') }}">
                            </div>
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="discount_percentage">Giảm giá sản phẩm (mặc định là 0%)</label>
                                <input type="number" step="any" class="form-control" id="product-discount-percentage"
                                    name="discount_percentage" placeholder="Mặc định 0%"
                                    value="{{ old('discount_percentage') }}">
                            </div>
                            @error('discount_percentage')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="stock">Tồn kho</label>
                                <input type="number" class="form-control" id="product-stock" name="stock"
                                    placeholder="Nhập tồn kho của sản phẩm" value="{{ old('stock') }}">
                            </div>
                            @error('stock')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="product-category">Danh mục sản phẩm</label>
                                <div class="form-group">
                                    <select id="product-category" name="product_category_id" class="form-control">
                                        <option value="">---Chọn---</option>
                                        @foreach ($categoryList as $category)
                                            <option {{ old('product_category_id') === $category->id ? 'selected' : '' }}
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
                                        value="1"
                                        {{ old('status') === '1' || old('status') === null ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_active">Đang bán</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_inactive"
                                        value="0" {{ old('status') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_inactive">Tạm ngưng</label>
                                </div>
                            </div>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="modal-submit" name="create_product"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    @include('admin.blocks.notification')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script type="text/javascript">
        // Description Form input
        const quill = new Quill('#description_html', {
            theme: 'snow'
        });

        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById("product-description").value = quill.root.innerHTML;
        });

        const oldDescription = document.getElementById("old_description").value;
        if (oldDescription) {
            quill.clipboard.dangerouslyPasteHTML(oldDescription);
        }
        $(document).ready(function() {
            const mainImagePath = "{{ asset(App\Models\Product::MAIN_IMAGE_PATH) }}/";
            const defaultImage =
                "{{ asset(App\Models\Product::MAIN_IMAGE_PATH . '/' . App\Models\Product::DEFAULT_IMAGE) }}";
            // Create
            $('#btn-create').on('click', function() {
                $('#productModalLabel').text('Thêm sản phẩm');
                $('#product-form').attr('action', "{{ route('admin.product.store') }}");
                $('#modal-submit').text('Thêm sản phẩm').removeClass('btn-success').addClass('btn-primary');

                $('#create-image-section').removeClass('d-none');
                $('#edit-image-section').addClass('d-none');
                $('#method-put').remove();

                $('#current-main-image').attr('src', defaultImage).data('original-src', defaultImage);
            });

            // Info
            $(document).on('click', '.btn-product-info', function() {
                let productId = $(this).data('product-id');

                if (!productId) {
                    alert("Vui lòng làm mới trang để xem thông tin sản phẩm vừa tạo!");
                    return;
                }

                let detailUrl = "{{ route('admin.product.detail', ':id') }}".replace(':id',
                    productId);
                let updateUrl = "{{ route('admin.product.update', ':id') }}".replace(':id',
                    productId);

                $('#productModalLabel').text('Chi tiết & Cập nhật sản phẩn');
                $('#modal-submit').text('Lưu thay đổi').removeClass('btn-primary').addClass('btn-success');
                $('#product-form').attr('action', updateUrl);

                $('#create-image-section').addClass('d-none');
                $('#edit-image-section').removeClass('d-none');

                $.ajax({
                    url: detailUrl,
                    type: 'GET',
                    success: function(data) {
                        $('#product-name').val(data.name);
                        $('#product-price').val(data.price);
                        $('#product-discount-percentage').val(data.discount_percentage);
                        $('#product-stock').val(data.stock);

                        $('#product-category').val(data.product_category_id);

                        if (typeof quill !== 'undefined') {
                            quill.clipboard.dangerouslyPasteHTML(data.description || '');
                        }

                        let imgSrc = data.main_image ? (mainImagePath + data.main_image) : defaultImage;

                        $('#current-main-image').attr('src', imgSrc).data('original-src',
                            imgSrc);

                        if (data.status == 1) {
                            $('#status_active').prop('checked', true);
                        } else {
                            $('#status_inactive').prop('checked', true);
                        }
                        $('#productModal').modal('show');
                    }
                });
            });

            // Change Image
            $('#change-main-image-btn').on('click', function(e) {
                e.preventDefault();
                $('#edit-image-input').click();
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

            // Close Modal
            $('#productModal').on('hidden.bs.modal', function() {
                $('#product-form')[0].reset();
                $(this).find('.alert-danger').remove();
                $('#cancel-change-image-btn').addClass('d-none');
                $('#status_active').prop('checked', true);

                $('#current-main-image').attr('src', defaultImage).data('original-src', defaultImage);
                $('#edit-image-input').val('');
            });
        })
    </script>
@endsection
