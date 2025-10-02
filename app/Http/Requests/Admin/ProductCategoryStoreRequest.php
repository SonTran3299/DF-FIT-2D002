<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryStoreRequest extends FormRequest
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
            'name' => 'min:1|max:255|required|unique:product_category,name',
            'slug' => 'min:1|max:255|required',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Bắt buộc phải nhập tên',
            'name.min' => 'Nhập tên lớn hơn 1',
            'status.required' => 'Chọn trạng thái'
        ];
    }
}
