<?php

namespace App\Http\Requests\Admin;

class ProductUpdateRequest extends ProductStoreRequest
{
    public function rules(): array
    {
       return [
            'name' => 'min:1|max:255|required|unique:product,name,'.$this->route('product')->id,
            'price' => 'required',
            'product_category_id' => 'required',
            'status' => 'required',
            'discount_percentage' => 'nullable|numeric|min:0|max:1',
            'stock' => 'required|min:1',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ];
    }
}
