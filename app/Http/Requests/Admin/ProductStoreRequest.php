<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'min:1|max:255|required|unique:product,name',
            'price' => 'required',
            'product_category_id' => 'required',
            'status' => 'required',
            'discount_percentage' => 'nullable|numeric|min:0|max:1',
            'stock' => 'required|min:1',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Bắt buộc phải nhập tên',
            'name.min' => 'Nhập tên lớn hơn 1',
            'name.max' => 'Tên quá dài',
            'price.required' => 'Thêm giá tiền cho sản phẩm',
            'status.required' => 'Chọn trạng thái',
            'product_category_id.required' => 'Chọn danh mục sản phẩm',
            'discount_percentage.min' => 'Nhập giá trị trong khoảng 0 - 1.0',
            'discount_percentage.max' => 'Nhập giá trị trong khoảng 0 - 1.0',
            'stock.required' => 'Nhập tồn kho sản phẩm',
            'stock.min' => 'Nhập tồn kho lớn hơn 1',
        ];
    }
}
