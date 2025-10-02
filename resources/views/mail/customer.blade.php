<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
    <h1>Thông tin đơn hàng</h1>
    <div>
        <div>
            <p>Xin chào {{ $user->name }}.</p>
            <p>Bạn đã mua thành công đơn hàng <span style="color: #ef4444; font-weight: 700">{{ $order->id }}</span>,
                đơn hàng sẽ sớm
                được giao.</p>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Số lượng</th>
                    <th>Tổng cộng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $orderItem)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $orderItem->name }}</td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>{{ number_format($orderItem->quantity * $orderItem->price) }} VND</td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50">
                    <td colspan="3">
                        Tổng cộng:</td>
                    <td> {{ number_format($order->total) }} VND</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
