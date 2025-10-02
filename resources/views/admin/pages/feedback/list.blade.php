@extends('admin.layout.master')

@section('content')
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3>
                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                </h3>
                <h3 class="card-title">Phản hồi của khách hàng</h3>
            </div>

            {{-- Search --}}
            {{-- @include('admin.blocks.search_form', ['actionFormRoute' => route('admin.user.list')]) --}}

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Phản hồi</th>
                            <th>Trạng thái</th>
                            <th>Ngày gửi</th>
                            <th>Ngày phản hồi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->phone }}</td>
                                <td>{{ $data->message }}</td>
                                <td>{{ $data->status_to_text }}</td>
                                <td>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td>{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.feedback.detail', ['contact' => $data->id]) }}"
                                        class="btn btn-outline-info"><i class="fa fa-eye"></i></a>
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
