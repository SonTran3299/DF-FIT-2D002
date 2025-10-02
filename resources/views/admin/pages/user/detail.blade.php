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
                <h3 class="card-title">Thông tin khách hàng</h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"> 
                            <span class="font-weight-bold">Tên: </span>
                            <span>{{ $user->name ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Email: </span>
                            <span>{{ $user->email ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Số điện thoại: </span>
                            <span>{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Địa chỉ: </span>
                            <span>{{ $user->address ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Vai trò: </span>
                            <span>{{ $user->role === 0 ? 'thành viên' : 'admin'}}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Ngày tạo: </span>
                            <span>
                                {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Ngày cập nhật: </span>
                            <span>
                                {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
