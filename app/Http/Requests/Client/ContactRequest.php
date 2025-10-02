<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|digits_between:10,15',
            'message' => 'required|string',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Nhập tên của bạn',
            'email.required' => 'Nhập email của bạn',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'phone.required' => 'Nhập số điện thoại của bạn',
            'message.required' => 'Vui lòng nhập nội dung',
        ];
    }
}
