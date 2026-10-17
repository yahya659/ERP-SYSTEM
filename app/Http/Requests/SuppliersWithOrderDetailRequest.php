<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuppliersWithOrderDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'item_code' => 'required|exists:item_cards,item_code',

            'unit_id' => 'required|exists:inv_uoms,id',

            'delivery_quantity' => 'required|numeric|min:1',

            'unit_price' => 'required|numeric|min:0',

            'total_price' => 'required|numeric|min:0',

            'production_date' => 'nullable|date',

            'expir_date' => 'nullable|date|after:production_date',

        ];
    }


    public function messages(): array
    {
        return [

            'item_code.required' => 'يجب اختيار الصنف',

            'unit_id.required' => 'يجب اختيار الوحدة',

            'delivery_quantity.required' => 'يجب إدخال الكمية',

            'unit_price.required' => 'يجب إدخال السعر',

            'total_price.required' => 'الإجمالي مطلوب',

            'expir_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ الإنتاج',

        ];
    }
}
