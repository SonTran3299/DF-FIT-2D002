<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;
    case CONFIRMED = 1;
    case SHIPPING = 2;
    case DELIVERED = 3;
    case CANCELLED = 4;
    case DELIVERY_FAILED = 5;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Chờ xử lý',
            self::CONFIRMED => 'Xác nhận đơn hàng',
            self::SHIPPING => 'Đang giao hàng',
            self::DELIVERED => 'Giao thành công',
            self::CANCELLED => 'Đã hủy',
            self::DELIVERY_FAILED => 'Giao hàng thất bại',
        };
    }

    // public function color(): string
    // {
    //     return match ($this) {
    //         self::PENDING => 'warning',
    //         self::DELIVERED => 'success',
    //         self::CANCELLED, self::DELIVERY_FAILED => 'danger',
    //         default => 'info',
    //     };
    // }
}
