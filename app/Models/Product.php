<?php

namespace App\Models;

use App\Traits\HandleFormattedTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    const MAIN_IMAGE_PATH = 'images/product/main_image';
    const PRODUCT_IMAGE_PATH = 'images/product/product_image';
    const DEFAULT_IMAGE = 'default-product-image.jpg';

    use HasFactory, SoftDeletes;
    use HandleFormattedTimestamps;

    protected $table = 'product';

    public $guarded = [];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
}
