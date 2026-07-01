<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SuppliersCategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
               'name' => 'required|unique:inv_itemscard_categories,name,' . $this->route('inv_itemscard_category'),//عند التعديل لو ماتشتي تعدل الااسم مايعدله
            'active' => 'required|in:0,1',
        ];
    }
     public function messages()
    {
        return[

            'name.required' =>'حقل الاسم مطلوب ',
            'name.unique' => 'اسم المورد موجود مسبقاً، الرجاء إدخال اسم آخر',

            'active.required'=>'حقل الحالة مطلوب',
            'active.in'=>'حقل الحالة يجب ان يكون 0 او 1'

        ];
    }
}
