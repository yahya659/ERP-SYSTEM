<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreasuriesTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'admin_shift_id' => 'required|exists:admins_shift,id',

            'accauont_number' => 'required|exists:accauonts,id',

            'money' => 'required|numeric|min:0.01',

            'move_date' => 'required|date',

            'bayan' => 'required|string|max:1000',
             'mov_type' => 'required  ',
        ];
    }

    public function messages(): array
    {
        return [
            'admin_shift_id.required' => 'يجب اختيار الشفت',

            'admin_shift_id.exists' => 'الشفت غير موجود',

            'accauont_number.required' => 'يجب اختيار الحساب المالي',

            'accauont_number.exists' => 'الحساب المالي غير موجود',

            'money.required' => 'يجب إدخال قيمة المبلغ',

            'money.numeric' => 'قيمة المبلغ يجب أن تكون رقمًا',

            'money.min' => 'قيمة المبلغ يجب أن تكون أكبر من صفر',

            'move_date.required' => 'يجب إدخال تاريخ الحركة',

            'move_date.date' => 'تاريخ الحركة غير صحيح',

            'bayan.required' => 'يجب إدخال البيان',
            'bayan.max' => 'البيان يجب ألا يتجاوز 1000 حرف',
            'mov_type.required' => 'اختر نوع الحركه    ',
        ];
    }
}
