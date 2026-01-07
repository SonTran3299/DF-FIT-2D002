<?php

namespace App\Models;

use App\Traits\HandleFormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    const IMAGE_PATH = 'images/category';
    const DEFAULT_IMAGE = 'default_product.svg';

    use HasFactory, SoftDeletes;
    use HandleFormattedTimestamps;

    protected $table = 'product_category';

    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}
