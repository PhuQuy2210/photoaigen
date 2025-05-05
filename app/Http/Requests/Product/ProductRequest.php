<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|numeric',
            'thumb' => 'nullable|mimes:jpg,jpeg,png,gif|max:8192|required_without:thumb_old', // Ảnh chỉ bắt buộc khi không có ảnh cũ
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên Danh Mục',
            'thumb.mimes' => 'Hình ảnh phải là tệp có đuôi: jpg, jpeg, png, gif',
            'thumb.max' => 'Dung lượng hình ảnh không được vượt quá 8MB',
            'thumb.required_without' => 'Hình ảnh không được bỏ trống',
        ];
    }
}
