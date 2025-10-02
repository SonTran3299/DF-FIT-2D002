{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vnpay_asset/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="asset('vnpay_asset/jumbotron-narrow.css')" rel="stylesheet">
    <script src="asset('vnpay_asset/jquery-1.11.3.min.js')"></script>
</head>

<body> --}}
@extends('client.layout.master')
@section('main-content')
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">KẾT QUẢ THANH TOÁN VNPAY</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>
                <label>{{ $data['vnp_TxnRef'] }}</label>
            </div>
            <div class="form-group">
                <label>Số tiền:</label>
                <label>{{ number_format($data['vnp_Amount'] / 100, 0, ',', '.') }} VNĐ</label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label>{{ $data['vnp_OrderInfo'] }}</label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label>{{ $data['vnp_ResponseCode'] }}</label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label>{{ $data['vnp_TransactionNo'] }}</label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label>{{ $data['vnp_BankCode'] }}</label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label>{{ \Carbon\Carbon::parse($data['vnp_PayDate'])->format('d-m-Y H:i:s') }}</label>
            </div>
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                    @if ($secureHash == $data['vnp_SecureHash'])
                        @if ($data['vnp_ResponseCode'] == '00')
                            <span style='color:blue'>Giao dịch Thành công</span>
                        @else
                            <span style='color:red'>Giao dịch Không thành công</span>
                        @endif
                    @else
                        <span style='color:red'>Chữ ký không hợp lệ</span>
                    @endif
                </label>
            </div>
        </div>
        <p>&nbsp;</p>
        <footer class="footer">
            <p>&copy; VNPAY {{ date('Y') }}</p>
        </footer>
    </div>
@endsection

{{-- </body>

</html> --}}
