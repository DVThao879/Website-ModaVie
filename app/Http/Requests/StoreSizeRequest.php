<?php

namespace App\Http\Requests;

use App\Models\Size;
use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Size::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:sizes,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên size là bắt buộc',
            'name.max' => 'Tên size không được dài quá 100 ký tự',
            'name.unique' => 'Tên size này đã tồn tại trong hệ thống',
        ];
    }
}
