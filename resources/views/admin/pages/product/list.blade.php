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
                'createUrl' => route('admin.product.create'),
                'title' => 'Thêm sản phẩm',
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
                                    {{ $data->status ? 'Hiện' : 'Ẩn' }}
                                </td>
                                <td>{{ $data->productCategory?->name }}</td>
                                <td>{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.product.detail', ['product' => $data->id]) }}"
                                        class="btn btn-outline-info"><i class="fa fa-eye"></i></a>
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
@endsection
@section('my-js')
    @include('admin.blocks.notification')
@endsection
