<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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


    // nullable: Cho phép trường thumb có thể trống nếu người dùng không tải lên ảnh mới.
    // required_without:thumb_old: Ảnh mới chỉ bắt buộc nếu không có ảnh cũ (thumb_old).
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:10,15', // Số điện thoại phải có độ dài từ 10 đến 15 chữ số
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255', // Email phải hợp lệ và không trùng lặp
            'content' => 'nullable|string|max:500', // Content có thể để trống và có tối đa 500 ký tự
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits_between' => 'Số điện thoại phải từ 10 đến 15 chữ số.',

            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            // 'email.unique' => 'Email này đã được đăng ký.',

            'content.max' => 'Nội dung không được vượt quá 500 ký tự.',
            'content.required' => 'Nội dung không được để trống.',
        ];
    }
}
