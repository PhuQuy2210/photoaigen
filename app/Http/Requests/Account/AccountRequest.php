<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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


    //không được bỏ trống, Trường password_confirmation phải trùng khớp với giá trị của trường password.
    public function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:2'
        ];
    }

    public function messages(): array
    {
        return [
            "current_password.required" => "Mật khẩu cũ không được bỏ trống!!",
            "password.required" => "Mật khẩu mới không được bỏ trống!!!",
            "password.confirmed" => "Mật khẩu mới không giống nhau!!",
            "password.min" => "Mật khẩu mới tối thiệu 2 kí tự!!",
        ];
    }
}
