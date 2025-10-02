<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_SHIPPING = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_DELIVERY_FAILED = 5;

    use HasFactory;

    protected $table = 'order';

    public $guarded = [];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function orderPaymentMethods()
    {
        return $this->hasMany(OrderPaymentMethod::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor
    protected function statusToText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $statusArray = [
                    self::STATUS_PENDING => 'chờ xử lý',
                    self::STATUS_CONFIRMED => 'xác nhận đơn hàng',
                    self::STATUS_SHIPPING => 'đang giao',
                    self::STATUS_DELIVERED => 'giao thành công',
                    self::STATUS_CANCELLED => 'đã hủy',
                    self::STATUS_DELIVERY_FAILED => 'giao hàng thất bại'
                ];

                return $statusArray[$this->status] ?? 'Lỗi không xác định';
            },
        );
    }
}
