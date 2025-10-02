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
                'createUrl' => route('admin.product_category.create'),
                'title' => 'Thêm danh mục'
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
                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    @if (!is_null($data->deleted_at))
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
                                    <a href="{{ route('admin.product_category.detail', ['productCategory' => $data->id]) }}"
                                        class="btn btn-outline-info"><i class="fa fa-eye"></i></a>
                                    <form
                                        action="{{ route('admin.product_category.destroy', ['productCategory' => $data->id]) }}"
                                        method="post" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-danger" type="submit"
                                            onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')"><i class="fa fa-trash"></i></button>
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
@endsection

@section('my-js')
    @include('admin.blocks.notification')
@endsection