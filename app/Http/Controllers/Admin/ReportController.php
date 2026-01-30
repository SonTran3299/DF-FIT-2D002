<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SaleReportExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function saleSummary(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        if ($startDate->greaterThan($endDate)) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $dailyNetSaleReport = $this->getDailyNetSaleForDateRange($startDate, $endDate);

        $summaryData = $this->getFinancialSummaryForDateRange($startDate, $endDate);

        if ($request->has('export')) {
            return $this->exportExcel($request);
        }

        return view(
            'admin.pages.report.sale-summary',
            [
                'dailyNetSaleReport' => $dailyNetSaleReport,
                'summaryData' => $summaryData
            ]
        );
    }

    protected function getDailyNetSaleForDateRange(Carbon $startDate, Carbon $endDate): array
    {
        $chartData = [['Ngày', 'Doanh thu']];

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            // Lấy netSale cho ngày hiện tại
            $netSaleForDay = $this->calculateNetSaleForSpecificDay($currentDate);

            $chartData[] = [
                $currentDate->format('d/m'),
                $netSaleForDay
            ];
            $currentDate->addDay();
        }

        return $chartData;
    }

    private function calculateNetSaleForSpecificDay(Carbon $date): float
    {
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        $products = OrderItem::whereHas('order', function ($query) {
            $query->where('status', '!=', 5);
        })
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->get();

        $grossSale = 0;
        $discountAmount = 0;

        foreach ($products as $product) {
            $grossSale += $product->price * $product->quantity;
            $discountAmount += ($product->price * $product->quantity) * $product->discount_percentage;
        }

        $operatingExpensePerDay = 0;

        $totalExpenseForDay = $operatingExpensePerDay + $discountAmount;

        return (int)($grossSale - $totalExpenseForDay);
    }

    protected function getFinancialSummaryForDateRange(Carbon $startDate, Carbon $endDate): array
    {
        $products = OrderItem::whereHas('order', function ($query) {
            $query->where('status', '!=', 5);
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        $grossSale = 0;
        $discountAmount = 0;
        $totalOperatingExpense = 0;

        // Số ngày đã chọn để tính tổng chi phí
        $daysInPeriod = $startDate->diffInDays($endDate) + 1; // +1 vì diffInDays không tính ngày cuối
        $operatingExpensePerDay = 0; // Chi phí hoạt động cố định hàng ngày
        $totalOperatingExpense = $operatingExpensePerDay * $daysInPeriod;

        foreach ($products as $product) {
            $grossSale += $product->price * $product->quantity;
            $discountAmount += ($product->price * $product->quantity) * $product->discount_percentage;
        }

        $totalExpense = $totalOperatingExpense + $discountAmount;
        $netSale = $grossSale - $totalExpense;

        return [
            'grossSale' => $grossSale,
            'netSale' => $netSale,
            'expense' => $totalExpense,
            'totalOrders' => $totalOrders
        ];
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Lấy dữ liệu theo khoảng thời gian đã lọc
        $orders = Order::with('user:id,name')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('id', 'user_id', 'created_at', 'total')
            ->get();

        $fileName = 'sale_summary_report' . Carbon::now()->format('d-m-Y') . '.xlsx';

        return Excel::download(new SaleReportExport($orders), $fileName);
    }
}
