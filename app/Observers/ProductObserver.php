<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function creating(Product $product): void
    {
        if ($product->stock === 0) {
            $product->status = 0;
        }
    }

    public function updating(Product $product): void
    {
        if ($product->isDirty('stock') && $product->stock == 0) {
            $product->status = 0;
        } else if ($product->isDirty('stock') && $product->stock > 0) {
            $product->status = 1;
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
