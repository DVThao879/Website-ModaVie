<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $id = $this->route('product')->id; 

        return [
            'name' => 'required|string|max:255|unique:products,name,'.$id,
            'sku' => 'required|unique:products,sku,'.$id,
            'img_thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0',
            'description' => 'required',
            'category_id' => 'required',
            'status' => 'required',
            'is_active' => 'required',
            'product_galleries.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.size_id' => 'required',
            'variants.*.color_id' => 'required',
            'variants.*.quantity' => 'required|integer|min:1',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.price_sale' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.string' => 'Tên sản phẩm phải là một chuỗi văn bản',
            'name.max' => 'Tên sản phẩm không được dài quá 255 ký tự',
            'name.unique' => 'Tên sản phẩm này đã tồn tại trong hệ thống',

            'sku.required' => 'Mã sản phẩm là bắt buộc',
            'sku.unique' => 'Mã sản phẩm này đã tồn tại trong hệ thống',

            'img_thumb.image' => 'Phải là một hình ảnh',
            'img_thumb.mimes' => 'Chỉ được phép có định dạng jpeg, png, jpg, hoặc gif',
            'img_thumb.max' => 'Không được vượt quá 2048KB',

            'price.required' => 'Giá sản phẩm là bắt buộc',
            'price.numeric' => 'Giá sản phẩm phải là một số',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0',

            'price_sale.numeric' => 'Giá khuyến mãi phải là một số',
            'price_sale.min' => 'Giá khuyến mãi không được nhỏ hơn 0',

            'description.required' => 'Mô tả sản phẩm là bắt buộc',

            'category_id.required' => 'Vui lòng chọn danh mục',

            'status.required' => 'Vui lòng chọn trạng thái',

            'is_active.required' => 'Vui lòng chọn trạng thái',
            
            'product_galleries.*.image' => 'Mỗi ảnh trong bộ sưu tập phải là một hình ảnh',
            'product_galleries.*.mimes' => 'Mỗi ảnh trong bộ sưu tập chỉ được phép có định dạng jpeg, png, jpg, hoặc gif',
            'product_galleries.*.max' => 'Mỗi ảnh trong bộ sưu tập không được vượt quá 2048KB',

            'variants.*.size_id.required' => 'Chưa chọn size',

            'variants.*.color_id.required' => 'Chưa chọn màu',

            'variants.*.quantity.required' => 'Số lượng là bắt buộc',
            'variants.*.quantity.integer' => 'Số lượng phải là một số nguyên',
            'variants.*.quantity.min' => 'Số lượng không được nhỏ hơn 0',

            'variants.*.price.required' => 'Giá là bắt buộc',
            'variants.*.price.numeric' => 'Giá phải là một số',
            'variants.*.price.min' => 'Giá không được nhỏ hơn 0',

            'variants.*.price_sale.numeric' => 'Giá KM phải là một số',
            'variants.*.price_sale.min' => 'Giá KM không được nhỏ hơn 0',
        ];
    }
}
