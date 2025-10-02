@extends('admin.layout.master')

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tạo sản phẩm mới</h3>
            </div>
            <form role="form" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="main-image">Ảnh sản phẩm</label>
                        <input type="file" class="form-control" id="main-image" name="main_image">
                    </div>
                    @error('main_image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="description">Mô tả sản phẩm</label>
                        <div id="description_html"></div>
                        <input type="hidden" name="description" id="description">
                        <input type="hidden" name="old_description" id="old_description" value="{{ old('description') }}">
                    </div>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input type="number" class="form-control" id="price" name="price"
                            placeholder="Nhập giá của sản phẩm" value="{{ old('price') }}">
                    </div>
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="discount_percentage">Giảm giá sản phẩm (nếu cần)</label>
                        <input type="number" step="any" class="form-control" id="discount_percentage" name="discount_percentage"
                            placeholder="Mặc định 0%" value="{{ old('discount_percentage') }}">
                    </div>
                    @error('discount_percentage')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <div class="form-group">
                        <label for="stock">Tồn kho</label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            placeholder="Nhập tồn kho của sản phẩm" value="{{ old('stock') }}">
                    </div>
                    @error('stock')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="category">Danh mục sản phẩm</label>
                        <div class="form-group">
                            <select id="category" name="product_category_id" class="form-control">
                                <option value="">---Chọn---</option>
                                @foreach ($categoryList as $data)
                                    <option {{ old('product_category_id') === $data->id ? 'selected' : '' }}
                                        value="{{ $data->id }}">
                                        {{ Str::title($data->name) }}</option>
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
                            <input class="form-check-input" type="radio" name="status" id="status_active" value="1"
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
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="create_product">Tạo sản phẩm</button>
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
    </script>
    {{-- <script type="text/javascript">
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
        });
    </script> --}}
@endsection
