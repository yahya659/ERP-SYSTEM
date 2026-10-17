<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class Admin__panel__settings extends FormRequest
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
            //التحقق الذي هي فيلديشن
            'system_name'=>'required',
            'com_code'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'general_alert'=>'nullable',
            'active'=>'required|in:0,1',
            'customer_parent_number'=>'required',
            'supplier_parent_number'=>'required',
            'delegates_parent_number'=>'required',
            'employees_parent_number'=>'required',

        ];

    }
    //  ؤساله اذا  المستخدم لم يدخل البيانات
    public function messages()
    {
        return[
            'system_name.required'=>'حقل اسم الشركة مطلوب ',
            'com_code.required'=>'حقل كود الشركة مطلوب',
            'address.required'=>'حقل العنوان مطلوب',
            'phone.required'=>'حقل الهاتف مطلوب',
            'customer_parent_number.required'=>'حقل اسم للعملاء الاب مطلوب',
            'supplier_parent_number.required'=>'حقل اسم للموردين الاب مطلوب',
            'delegates_parent_number.required'=>'حقل اسم المندوب الاب مطلوب',
            'employees_parent_number.required'=>'حقل اسم الموظف الاب مطلوب',
            'active.required'=>'حقل التفعيل مطلوب',
            'active.in'=>'حقل التفعيل يجب ان يكون 0 او 1',


        ];
    }
}
