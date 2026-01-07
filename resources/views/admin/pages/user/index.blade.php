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
                <h3 class="card-title">Danh sách người dùng</h3>
            </div>

            {{-- Search --}}
            @include('admin.blocks.search_form', ['actionFormRoute' => route('admin.user.list')])

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Ngày đăng ký</th>
                            <th>Ngày cập nhật</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->role ? 'admin' : 'thành viên' }}</td>
                                <td>{{ $data->formatted_created_at }}</td>
                                <td>{{ $data->formatted_updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-info btn-view-detail"
                                        data-id="{{ $data->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
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

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Thông tin người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="mb-2">
                            <span class="font-weight-bold">Tên: </span>
                            <span id="userName"></span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Email: </span>
                            <span id="userEmail"></span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Số điện thoại: </span>
                            <span id="userPhone"></span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Địa chỉ: </span>
                            <span id="userAddress"></span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Vai trò: </span>
                            <span id="userRole"></span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Ngày tạo: </span>
                            <span id="userCreatedAt"></span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Ngày cập nhật: </span>
                            <span id="userUpdatedAt"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('my-js')
    <script>
        $(document).ready(function() {
            $('.btn-view-detail').on('click', function() {
                let userId = $(this).data('id');
                let url = "{{ route('admin.user.detail', ':user') }}".replace(':user', userId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(user) {
                        // Load data into the Modal
                        $('#userName').text(user.name);
                        $('#userEmail').text(user.email);
                        $('#userPhone').text(user.phone);
                        $('#userAddress').text(user.address);
                        let roleText = (user.role == 0) ? 'Thành viên' : 'Admin'
                        $('#userRole').text(roleText);
                        $('#userCreatedAt').text(user.formatted_created_at);
                        $('#userUpdatedAt').text(user.formatted_updated_at);

                        // Show modal
                        $('#userModal').modal('show');
                    }
                })
            })
        })
    </script>
@endsection
