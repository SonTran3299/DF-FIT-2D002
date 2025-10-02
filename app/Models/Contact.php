<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    const STATUS_NEW = 0;
    const STATUS_PROCESS = 1;
    const STATUS_SUCCESS = 2;

    use HasFactory;

    protected $table = 'contact';

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function statusToText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $statusArray = [
                    self::STATUS_NEW => 'Mới',
                    self::STATUS_PROCESS => 'Đang xử lý',
                    self::STATUS_SUCCESS => 'Đã phản hồi'
                ];

                return $statusArray[$this->status] ?? 'Lỗi không xác định';
            },
        );
    }
}
