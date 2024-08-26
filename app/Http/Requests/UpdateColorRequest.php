<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColorRequest extends FormRequest
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
        // Lấy ID từ route
        $id = $this->route('color')->id;

        return [
            'name' => 'required|string|max:100|unique:colors,name,'.$id,
            'hex_code' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/|size:7|unique:colors,hex_code,'.$id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên màu là bắt buộc',
            'name.string' => 'Tên màu phải là một chuỗi văn bản',
            'name.max' => 'Tên màu không được dài quá 100 ký tự',
            'name.unique' => 'Tên màu này đã tồn tại trong hệ thống',

            'hex_code.required' => 'Mã màu là bắt buộc',
            'hex_code.string' => 'Mã màu phải là một chuỗi văn bản',
            'hex_code.regex' => 'Mã màu phải phù hợp với định dạng mã màu hex (ví dụ: #FF5733)',
            'hex_code.size' => 'Mã màu phải có độ dài chính xác là 7 ký tự',
            'hex_code.unique' => 'Mã màu này đã tồn tại trong hệ thống',
        ];
    }
}
