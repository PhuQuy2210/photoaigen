<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email', 
            'role_id' => 'required|exists:roles,id', // ID role phải tồn tại trong bảng roles
            'active' => 'required|boolean',
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên tài khoản là bắt buộc.',
            'name.string' => 'Tên tài khoản phải là một chuỗi ký tự.',
            'name.max' => 'Tên tài khoản không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'role_id.required' => 'Vai trò là bắt buộc.',
            'role_id.exists' => 'Vai trò được chọn không hợp lệ.',
            'active.required' => 'Trạng thái kích hoạt là bắt buộc.',
            'active.boolean' => 'Trạng thái kích hoạt không hợp lệ.',
        ];
    }
}
