<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
{
   public function rules(): array
    {

        $rules = [

            'name' => 'required|unique:customers,name,' . $this->route('customers'),
            'name' => 'required',
            // 'phone' => 'required|unique:customers,phone',
            'phone'=>'required',
            'address'=>'required',
            'active' => 'required',
            'nodes' => 'nullable|string|max:255',
        ];


        // فقط عند الإضافة احتاج هولا ....عند التعديل ماحتاجهن
        if ($this->isMethod('post')) {

            $rules['start_balance'] = 'required|numeric';

            $rules['start_balance_status'] = 'required|in:0,1,2';

        }


        return $rules;
    }



    public function messages()
    {
        return [

            'name.required' => 'حقل الاسم اجباري',

            'name.unique' => 'اسم الحساب موجود مسبقاً، الرجاء إدخال اسم آخر',
            //  'phone.unique' => 'الرقم هذا مستخدم سابقاً',
             'phone.required'=>'يرجاء ادخال رقم العميل',
            'address.required'=>'يرجاء ادخال  العنوان',
            'active.required' => 'اجباري اختيار حالة ',



            'start_balance.required' => 'اجباري إدخال القيمة الافتتاحية',

            'start_balance.numeric' => 'القيمة الافتتاحية يجب أن تكون رقم',

            'start_balance_status.required' => 'اجباري إدخال حالة الرصيد',

            'start_balance_status.in' => 'حالة الرصيد غير صحيحة',



        ];
    }
}
