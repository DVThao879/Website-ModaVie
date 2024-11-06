<?php

namespace App\Http\Requests;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Blog::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:blogs,title',
            'content' => 'required|string',
            'img_avt' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được quá 255 ký tự',
            'title.unique' => 'Tiêu đề đã tồn tại',

            'content.required' => 'Nội dung là bắt buộc',

            'img_avt.required' => 'Bạn chưa chọn ảnh đại diện',
            'img_avt.image' => 'Tệp tải lên phải là một ảnh',
            'img_avt.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng: jpeg, png, jpg, gif, webp',
            'img_avt.max' => 'Kích thước ảnh đại diện không được vượt quá 2MB',
        ];
    }
}
