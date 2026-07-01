<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InvuomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function rules(): array
    {
        return [
            //التحقق الذي هي فيلديشن
            'name' => 'required|unique:inv_uoms,name,' . $this->route('id'),//عند التعديل لو ماتشتي تعدل الااسم مايعدله
            'is_master' => 'required',
             'active'=>'required|in:0,1',

        ];

    }
    //  ؤساله اذا  المستخدم لم يدخل البيانات
    public function messages()
    {
        return[

            'name.required' =>'حقل الاسم مطلوب ',
            'name.unique' => 'اسم الفئه موجود مسبقاً، الرجاء إدخال اسم آخر',

            'active.required'=>'حقل الحالة مطلوب',
            'active.in'=>'حقل الحالة يجب ان يكون 0 او 1'

        ];
    }
}
