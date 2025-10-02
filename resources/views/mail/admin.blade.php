<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
    <h1>Admin</h1>
    <table class="min-w-full divide-y divide-gray-200 shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên</th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng cộng
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($order->orderItems as $orderItem)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $orderItem->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $orderItem->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ number_format($orderItem->quantity * $orderItem->price) }} VND</td>
                </tr>
            @endforeach
            <tr class="bg-gray-50">
                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-right text-base font-semibold text-gray-900">
                    Tổng cộng:</td>
                <td class="px-6 py-4 whitespace-nowrap text-base font-semibold text-gray-900">
                    {{ number_format($order->total) }} VND</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
