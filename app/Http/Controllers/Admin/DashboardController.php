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
                'productSold' => self::getSoldProductsCount($month, $year),
                'orderCount' => self::getNewOrderCount(),
                'userCount' => User::count() - 1,
                //'successRate' => self::calculateSuccessfulDeliveryRate(),
                'monthlyReport' => $this->getChartDataForLastThreeMonths(),
                'monthlyRevenue' => $this->getMonthlyFinancialSummary($month, $year)
            ]
        );
    }

    protected function getNewOrderCount()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
    }

    protected static function getSoldProductsCount(string|int $month, string|int $year)
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

    // Calculate the percentage of successfully delivered orders in the month
    // protected static function calculateSuccessfulDeliveryRate(): float
    // {
    //     $total = Order::whereIn('status', [3, 5])->count();
    //     $totalDelivered = Order::where('status', 3)->count();

    //     $rate = 0;
    //     if ($total > 0) {
    //         $rate = ($totalDelivered / $total) * 100;
    //     }
    //     return round($rate, 2);
    // }

    protected function getMonthlyFinancialSummary(string|int $month, string|int $year): array
    {
        $month = (int)$month;
        $year = (int)$year;

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();

        // Orders successfully processed during this period
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

    // Data from the last 3 months
    protected function getChartDataForLastThreeMonths(): array
    {
        $chartData = [['Tháng', 'GROSS', 'NET', 'CHI PHÍ']];
        $today = Carbon::now();

        // Retrieve data for the last 3 months (including the current month)
        for ($i = 0; $i < 3; $i++) {
            $date = $today->copy()->subMonths($i); 

            $month = $date->month;
            $year = $date->year;

            $monthlySummary = $this->getMonthlyFinancialSummary($month, $year);

            $label = ucfirst($date->monthName) . ' ' . $year;

            // Add data to the chartData array
            $chartData[] = [
                $label,
                $monthlySummary['grossSale'],
                $monthlySummary['netSale'],
                $monthlySummary['expense']
            ];
        }

        // Reverse the array (except for the header) to display from oldest to newest month
        $header = array_shift($chartData);
        $chartData = array_reverse($chartData);
        array_unshift($chartData, $header);

        return $chartData;
    }
}
