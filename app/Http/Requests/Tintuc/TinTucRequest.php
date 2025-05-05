<?php

namespace App\Http\Requests\Tintuc;

use Illuminate\Foundation\Http\FormRequest;

class TinTucRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Thay đổi nếu có logic xác thực quyền
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255', // Bắt buộc nhập tiêu đề, không quá 255 ký tự
            'author_id' => 'required|string|max:255', // Tên tác giả bắt buộc, không quá 255 ký tự
            'description' => 'required|string|max:1000', // Mô tả bắt buộc, không quá 1000 ký tự
            'content' => 'required|string', // Nội dung bắt buộc
            'category_id' => 'required|integer', // Danh mục bắt buộc, phải tồn tại trong bảng categories
            'url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8048', // Hình ảnh không bắt buộc, chỉ cho phép định dạng ảnh, tối đa 2MB
        ];
    }

    /**
     * Get the custom messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để trống.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'author_id.required' => 'Tác giả không được để trống.',
            'author_id.max' => 'Tác giả không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả không được để trống.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'content.required' => 'Nội dung không được để trống.',
            'category_id.required' => 'Danh mục không được để trống.',
            'url.image' => 'Tệp tải lên phải là hình ảnh.',
            'url.mimes' => 'Chỉ cho phép tải lên các tệp có định dạng jpeg, png, jpg, gif.',
            'url.max' => 'Dung lượng hình ảnh không được vượt quá 8MB.',
        ];
    }
}
