<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        return view(
            'admin.pages.dashboard.index',
            [
                'productSold' => self::soldProducts($month, $year),
                'countOrder' => self::countNewOrder(),
                'countUser' => User::count() - 1,
                'successRate' => self::caculateSuccessfulDeliveryRate(),
                'reportMonthly' => $this->getChartDataForLastThreeMonths(),
            ]
        );
    }

    protected function countNewOrder()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
    }

    protected static function soldProducts(string|int $month, string|int $year)
    {
        $products = OrderItem::selectRaw('name, sum(quantity) as total')->whereMonth('updated_at', $month)
            ->whereYear('updated_at', $year)
            ->groupBy('name')->get();

        $chartData = [['Tên Sản phẩm', 'Số lượng đã bán']];
        foreach ($products as $item) {
            $chartData[] = [$item->name, (int) $item->total];
        }

        return $chartData;
    }

    protected static function caculateSuccessfulDeliveryRate(): float
    {
        $total = Order::whereIn('status', [3, 5])->count();
        $totalDelivered = Order::where('status', 3)->count();

        $rate = 0;
        if ($total > 0) {
            $rate = ($totalDelivered / $total) * 100;
        }
        return round($rate, 2);
    }

    protected function getMonthlyFinancialSummary(string|int $month, string|int $year): array
    {
        $month = (int)$month;
        $year = (int)$year;

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();

        // Lấy các mục đơn hàng đã hoàn thành trong khoảng thời gian này
        $products = OrderItem::whereHas('order', function ($query) { 
            $query->where('status', '!=', 5); 
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $grossSale = 0;
        $discountAmount = 0;

        foreach ($products as $product) {
            $grossSale += $product->price * $product->quantity;
            $discountAmount += ($product->price * $product->quantity) * $product->discount_percentage;
        }

        $operatingExpense = 0; // Các khoản chi phí (chưa tính)

        $totalExpense = $operatingExpense + $discountAmount;

        $netSale = $grossSale - $totalExpense;

        return [
            'grossSale' => $grossSale,
            'netSale' => $netSale,
            'expense' => $totalExpense 
        ];
    }

    protected function getChartDataForLastThreeMonths(): array
    {
        $chartData = [['Tháng', 'GROSS', 'NET', 'CHI PHÍ']];
        $today = Carbon::now();

        // Lấy dữ liệu cho 3 tháng gần nhất (gồm tháng hiện tại)
        for ($i = 0; $i < 3; $i++) {
            $date = $today->copy()->subMonths($i); 

            $month = $date->month;
            $year = $date->year;

            $monthlySummary = $this->getMonthlyFinancialSummary($month, $year);

            $label = ucfirst($date->monthName) . ' ' . $year;

            // Thêm dữ liệu vào mảng chartData
            $chartData[] = [
                $label,
                $monthlySummary['grossSale'],
                $monthlySummary['netSale'],
                $monthlySummary['expense']
            ];
        }

        // Đảo ngược mảng (trừ header) để biểu đồ hiển thị theo thứ tự thời gian (tháng cũ nhất đến tháng mới nhất)
        $header = array_shift($chartData); // Tách header
        $chartData = array_reverse($chartData); // Đảo ngược dữ liệu
        array_unshift($chartData, $header); // Đặt header lên đầu mảng

        return $chartData;
    }
}
