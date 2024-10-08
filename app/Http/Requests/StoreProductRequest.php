<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'sku' => 'required|string|unique:products,sku',
            'img_thumb' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price_min' => 'required|numeric|min:0|lt:price_max',
            'price_max' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'product_galleries' => 'required',
            'product_galleries.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.quantity' => 'required|integer|min:1',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.price_sale' => 'required|numeric|min:0|lt:variants.*.price',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Kiểm tra nếu danh mục có `is_active = 1`
            $category = Category::where('id', $this->category_id)
                ->where('is_active', 1)
                ->first();

            if (!$category) {
                $validator->errors()->add('category_id', 'Danh mục không hợp lệ hoặc đã bị vô hiệu hóa');
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.max' => 'Tên sản phẩm không được dài quá 255 ký tự',
            'name.unique' => 'Tên sản phẩm này đã tồn tại trong hệ thống',

            'sku.required' => 'Mã sản phẩm là bắt buộc',
            'sku.unique' => 'Mã sản phẩm này đã tồn tại trong hệ thống',

            'img_thumb.required' => 'Ảnh là bắt buộc',
            'img_thumb.image' => 'Phải là một hình ảnh',
            'img_thumb.mimes' => 'Chỉ được phép có định dạng jpeg, png, jpg, hoặc gif',
            'img_thumb.max' => 'Không được vượt quá 2048KB',

            'price_min.required' => 'Giá min là bắt buộc',
            'price_min.numeric' => 'Giá min phải là một số',
            'price_min.min' => 'Giá min không được nhỏ hơn 0',
            'price_min.lt' => 'Giá min phải nhỏ hơn giá max',

            'price_max.required' => 'Giá max là bắt buộc',
            'price_max.numeric' => 'Giá max phải là một số',
            'price_max.min' => 'Giá max không được nhỏ hơn 0',

            'description.required' => 'Mô tả sản phẩm là bắt buộc',

            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục đã chọn không tồn tại',

            'product_galleries.required' => 'Thư viện ảnh là bắt buộc',

            'product_galleries.*.required' => 'Thư viện ảnh là bắt buộc',
            'product_galleries.*.image' => 'Mỗi ảnh trong bộ sưu tập phải là một hình ảnh',
            'product_galleries.*.mimes' => 'Mỗi ảnh trong bộ sưu tập chỉ được phép có định dạng jpeg, png, jpg, hoặc gif',
            'product_galleries.*.max' => 'Mỗi ảnh trong bộ sưu tập không được vượt quá 2048KB',

            'variants.*.size_id.required' => 'Chưa chọn size',
            'variants.*.size_id.exists' => 'Kích thước không hợp lệ',

            'variants.*.color_id.required' => 'Chưa chọn màu',
            'variants.*.color_id.exists' => 'Màu không hợp lệ',

            'variants.*.quantity.required' => 'Số lượng là bắt buộc',
            'variants.*.quantity.integer' => 'Số lượng phải là một số nguyên',
            'variants.*.quantity.min' => 'Số lượng không được nhỏ hơn 0',

            'variants.*.price.required' => 'Giá là bắt buộc',
            'variants.*.price.numeric' => 'Giá phải là một số',
            'variants.*.price.min' => 'Giá không được nhỏ hơn 0',

            'variants.*.price_sale.required' => 'Giá KM là bắt buộc',
            'variants.*.price_sale.numeric' => 'Giá KM phải là một số',
            'variants.*.price_sale.min' => 'Giá KM không được nhỏ hơn 0',
            'variants.*.price_sale.lt' => 'Giá KM phải nhỏ hơn giá gốc',
        ];
    }
}
