<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreRequest extends FormRequest
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
                    //التحقق الذي هي فيلديشن
            'name' => 'required|unique:stores,name,' . $this->route('id'),//عند التعديل لو ماتشتي تعدل الااسم مايعدله
            // 'name' => 'required|unique:sales_material_types,name',//عند التعديل لو ماتشتي تعدل الااسم مايعدله


            'active'=>'required|in:0,1',
            'phones'=>'required',
            'address'=>'required',
        ];
    }
    #[Override]
    public function messages()
    {
        return[

            'name.required' =>'حقل الاسم مطلوب ',
            'name.unique' => 'اسم الفئه موجود مسبقاً، الرجاء إدخال اسم آخر',

            'active.required'=>'حقل الحالة مطلوب',
            'active.in'=>'حقل الحالة يجب ان يكون 0 او 1',
            'phones'=>'يرجاء ادخال الرقم',
            'address'=>'يرجاء ادخال العنوان',
        ];

    }
}
