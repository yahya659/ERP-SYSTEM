<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SuppliersWithOrdersGenralReturnRequest extends FormRequest
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
            'order_type'=>'nullable',
        'auto_serial'=>'nullable',
        // 'doc_no'=>'required',
        'order_date'=>'nullable',
        'supplier_id'=>'required',
        'is_approved'=>'nullable',
        'total_before_discount'=>'nullable',
        'discount_type'=>'nullable',
        'discount_value'=>'nullable',
        'tax_percent'=>'nullable',
        'tax_value'=>'nullable',
        'notes'=>'required',
        'total_cost'=>'nullable',
        'account_number'=>'nullable',
        'money_for_account'=>'nullable',
        'bill_type'=>'required',
        'store_id'=>'required',
        'what_paid'=>'nullable',
        'what_remain'=>'nullable',
        'treasury_transaction_id'=>'nullable',
        'supplier_balance_before'=>'nullable',
        'supplier_balance_after'=>'nullable',
        ];
    }
     public function messages()
    {
        return [
            'doc_no.required'=>'رقم الفاتوره مطلوب',
            'supplier_id.required'=>'اسم المورد مطلوب',
            'store_id.required'=>'اسم المخزن مطلوب',
            'notes.required'=>'يرجاء ادخال ملاحضه عن المورد',
            'bill_type.required'=>'نوع الفاتوره مطلوب',

        ];
    }
}
