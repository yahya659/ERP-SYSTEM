<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SalesInvoicactiveinvoiceRequest extends FormRequest
{
    /**
     * فاتوره الفعليه
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

        'invoice_date' => 'required|date',

        'is_has_customer' => 'required|in:0,1',

        'customer_code' => 'required_if:is_has_customer,1|nullable|exists:customers,id',

        'sales_material_types' => 'required|exists:sales_material_types,id',

'delegate_id' => 'required|exists:delegates,id',
    ];
}


public function messages()
{
    return [

        'invoice_date.required' => 'حقل التاريخ مطلوب',

        'is_has_customer.required' => 'يجب اختيار حالة العميل',

        'customer_code.required_if' => 'اختر العميل',

        'customer_code.exists' => 'العميل المحدد غير موجود',

        'sales_material_types.required' => 'نوع الفاتورة مطلوب',

        'sales_material_types.exists' => 'نوع الفاتورة المحدد غير موجود',

        'delegate_id.required' => 'اختر المندوب',

        'delegate_id.exists' => 'المندوب المحدد غير موجود',

    ];
}
}
