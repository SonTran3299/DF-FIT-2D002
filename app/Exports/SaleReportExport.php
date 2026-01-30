<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleReportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data->map(function ($order) {
            return [
                'Mã đơn' => $order->id,
                'Tên khách' => $order->user->name ?? 'N/A',
                'Ngày đặt' => $order->created_at->format('d-m-Y'),
                'Ngày giao thành công' => $order->updated_at->format('d-m-Y'),
                'Tổng tiền' => $order->total,
            ];
        });
    }

    // Tiêu đề file Excel
    public function headings(): array
    {
        return [
            'Mã Đơn Hàng',
            'Tên Khách Hàng',
            'Ngày Đặt',
            'Ngày Giao Thành Công',
            'Tổng Tiền (Net)',
        ];
    }
}
