<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class DelegateRequest extends FormRequest
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
               'name' => 'required|unique:customers,name,' . $this->route('customers'),
            'name' => 'required',
            // 'phone' => 'required|unique:customers,phone',
            'phone'=>'required',
            'address'=>'required',
            'active' => 'required',
            'parcent_type' => 'required',
            'parcent_sales_commission_katai' => 'required',
            'parcent_sales_commission_nosjamla' => 'required',
            'parcent_sales_commission_jomla' => 'required',
            'parcent_collection_commission' => 'required',
            'nodes' => 'nullable|string|max:255',


        ];
    }
    #[Override]
    public function messages()
    {
        return[

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

'parcent_type.required' => 'اجباري إدخال نوع عمولة المندوب',

'parcent_sales_commission_katai.required' => 'اجباري إدخال نسبة عمولة المندوب من المبيعات القطاعي',

'parcent_sales_commission_nosjamla.required' => 'اجباري إدخال نسبة عمولة المندوب من مبيعات نصف الجملة',

'parcent_sales_commission_jomla.required' => 'اجباري إدخال نسبة عمولة المندوب من مبيعات الجملة',

'parcent_collection_commission.required' => 'اجباري إدخال نسبة عمولة المندوب من تحصيل الفواتير الآجل',
        ];
    }
}
