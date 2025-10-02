<?php

namespace App\Http\Requests\Admin;

class ProductCategoryUpdateRequest extends ProductCategoryStoreRequest
{
    public function rules(): array
    {
        return [
            'name' => 'min:3|max:255|required|unique:product_category,name,' . $this->route('productCategory')->id,
            'slug' => 'min:1|max:255|required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
