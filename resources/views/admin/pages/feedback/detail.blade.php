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
                    <div class="card-header">
                        <h4 class="card-title">Chi tiết liên hệ</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="font-weight-bold">Tên: </span>
                            <span>{{ $contact->name ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Email: </span>
                            <span>{{ $contact->email ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Số điện thoại: </span>
                            <span>{{ $contact->phone ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Nội dung phản hồi của khách hàng: </span>
                            <span>{{ $contact->message ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Trạng thái: </span>
                            <span>{{ $contact->status_to_text ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Ngày gửi: </span>
                            <span>
                                {{ $contact->created_at ? \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="font-weight-bold">Ngày phản hồi: </span>
                            <span>
                                {{ $contact->updated_at ? \Carbon\Carbon::parse($contact->updated_at)->format('d/m/Y H:i:s') : '-' }}
                            </span>
                        </div>
                        @if (!is_null($contact->user_id))
                            <div class="mb-2">
                                <span class="font-weight-bold">Khách hàng đã đăng ký: </span>
                                <a href="{{ route('admin.user.detail', ['user' => $contact->user_id]) }}"
                                    class="">Thông tin</a>
                            </div>
                        @endif
                    </div>
                    <form class="card-body" action="{{ route('admin.feedback.answer', ['contact' => $contact->id]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">Gửi phản hồi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
