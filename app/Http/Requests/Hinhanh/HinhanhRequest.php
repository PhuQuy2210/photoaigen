<?php

namespace App\Http\Requests\Hinhanh;

use Illuminate\Foundation\Http\FormRequest;

class HinhanhRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện request này hay không.
     */
    public function authorize()
    {
        return true; // Cho phép thực hiện request
    }

    /**
     * Quy tắc xác thực cho request.
     */
    public function rules()
    {
        return [
            'direction' => 'required|in:0,1',
            'description' => 'nullable|string|max:5000',

            // Bắt buộc phải có ít nhất 1 ảnh
            'url' => 'required|array',
            'url.*' => 'image|mimes:jpeg,jpg,png,gif|max:10048',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages()
    {
        return [
            'direction.required' => 'Vui lòng chọn hướng ảnh.',
            'direction.in' => 'Giá trị của hướng ảnh không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 5000 ký tự.',

            'url.required' => 'Vui lòng chọn ít nhất một ảnh.',
            'url.array' => 'Danh sách ảnh không hợp lệ.',
            'url.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'url.*.mimes' => 'Hình ảnh phải có định dạng jpeg, jpg, png hoặc gif.',
            'url.*.max' => 'Dung lượng mỗi hình ảnh không được vượt quá 10MB.',
        ];
    }
}
