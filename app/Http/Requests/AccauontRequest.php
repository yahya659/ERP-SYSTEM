<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccauontRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        $rules = [

            'name' => 'required|unique:accauonts,name,' . $this->route('acaauont'),

            'accauont_types' => 'required',

            'is_parent' => 'required',

            'parient_accauont_number' => 'required_if:is_parent,0|nullable',

            'nodes' => 'nullable|string|max:255',

            'is_archived' => 'required',
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

            'accauont_types.required' => 'نوع الحساب اجباري',

            'is_parent.required' => 'يجب اختيار هل يملك أب',

            'parient_accauont_number.required_if' => 'يرجى اختيار حساب الأب',

            'start_balance.required' => 'اجباري إدخال القيمة الافتتاحية',

            'start_balance.numeric' => 'القيمة الافتتاحية يجب أن تكون رقم',

            'start_balance_status.required' => 'اجباري إدخال حالة الرصيد',

            'start_balance_status.in' => 'حالة الرصيد غير صحيحة',

            'is_archived.required' => 'اجباري اختيار حالة الأرشفة',

        ];
    }
}
