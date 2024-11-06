<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9}$/',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc',
            'name.max' => 'Tên không được vượt quá 255 ký tự',

            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',

            'address.required' => 'Địa chỉ là bắt buộc',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',

            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và gồm 10 số',

            'image.required' => 'Hình ảnh là bắt buộc',
            'image.image' => 'Phải là một hình ảnh',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, webp hoặc gif',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB',

            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải bao gồm ít nhất 1 chữ cái in hoa, 1 chữ cái thường và 1 chữ số',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp với mật khẩu đã nhập',
        ];
    }
}
