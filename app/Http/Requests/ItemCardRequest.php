<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ItemCardRequest extends FormRequest
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
        'name' => 'required|string|max:255',
        'item_type' => 'required|in:1,2,3',
        'inv_itemscard_categories_id' => 'required|exists:inv_itemscard_categories,id',
        'parent_inv_itemscard_id' => 'nullable|exists:item_cards,id',
        'uom_id' => 'required|exists:inv_uoms,id',
        'active' => 'required|in:0,1',
        'has_fixed_price' => 'nullable|in:0,1',
        'barcode' => 'nullable|string|max:255',
        'item_code' => 'nullable|numeric',

        // ===== مطلوب دائمًا =====
        'dose_has_retailunit' => 'required|in:0,1',

        // أسعار الوحدة الأساسية: مطلوبة في الحالتين
        'price' => 'required|numeric|min:0',
        'nos_gomla_price' => 'required|numeric|min:0',
        'wholesale_price' => 'required|numeric|min:0',
        'coast_price' => 'required|numeric|min:0',

        // ===== مطلوب فقط عند dose_has_retailunit = 1 =====
        'retail_uom' => 'required_if:dose_has_retailunit,1|nullable|string|max:255',
        'retail_uom_quantity_to_parent' => 'required_if:dose_has_retailunit,1|nullable|numeric|gt:0',
        'retail_price' => 'required_if:dose_has_retailunit,1|nullable|numeric|min:0',
        'nos_gomla_price_retail' => 'required_if:dose_has_retailunit,1|nullable|numeric|min:0',
        'wholesale_price_retail' => 'required_if:dose_has_retailunit,1|nullable|numeric|min:0',
        'coast_price_retail' => 'required_if:dose_has_retailunit,1|nullable|numeric|min:0',

        'image' => 'nullable|image|max:2048',

        'Quantity' => 'nullable|numeric',
        'Quantity_retail' => 'nullable|numeric',
        'Quantity_all_retail' => 'nullable|numeric',
    ];
}
     public function messages()
    {
        return [
            'dose_has_retailunit.required' => 'حدد هل يُباع الصنف بوحدة تجزئة أم لا',

'price.required' => 'ادخل سعر البيع للمستهلك',
'nos_gomla_price.required' => 'ادخل سعر نصف الجملة',
'wholesale_price.required' => 'ادخل سعر الجملة',
'coast_price.required' => 'ادخل سعر التكلفة',

'retail_uom.required_if' => 'اختر وحدة التجزئة',
'retail_uom_quantity_to_parent.required_if' => 'ادخل عدد الوحدات الصغيرة داخل الوحدة الكبيرة',
'retail_uom_quantity_to_parent.gt' => 'العدد يجب أن يكون أكبر من صفر',
'retail_price.required_if' => 'ادخل سعر التجزئة',
'nos_gomla_price_retail.required_if' => 'ادخل سعر نصف الجملة (تجزئة)',
'wholesale_price_retail.required_if' => 'ادخل سعر الجملة (تجزئة)',
'coast_price_retail.required_if' => 'ادخل سعر التكلفة (تجزئة)',

            'name.required'
                =>'اسم الصنف مطلوب',


            'item_type.required'
                =>'نوع الصنف مطلوب',


            'item_type.in'
                =>'نوع الصنف غير صحيح',
            'retail_price.required'
                =>'ادخل سعر التجزئه',
         


            'inv_itemscard_categories_id.required'
                =>'اختر فئة الصنف',


            'uom_id.required'
                =>'اختر وحدة القياس',


            'active.required'
                =>'حالة التفعيل مطلوبة',

'nos_gomla_price.numeric' => 'سعر النص جملة يجب أن يكون رقم',

'nos_gomla_price_retail.required' => 'ادخل سعر النص جملة (تجزئة)',
'nos_gomla_price_retail.numeric' => 'سعر النص جملة يجب أن يكون رقم',

'wholesale_price_retail.required' => 'ادخل سعر الجملة (تجزئة)',
'wholesale_price_retail.numeric' => 'سعر الجملة يجب أن يكون رقم',


'coast_price.numeric' => 'سعر التكلفة يجب أن يكون رقم',

'coast_price_retail.required' => 'ادخل سعر التكلفة (تجزئة)',
'coast_price_retail.numeric' => 'سعر التكلفة يجب أن يكون رقم',

'has_fixed_price.required' => 'حدد هل للصنف سعر ثابت أم لا',
'has_fixed_price.in' => 'قيمة السعر الثابت غير صحيحة',

'Quantity.required' => 'ادخل الكمية',
'Quantity.numeric' => 'الكمية يجب أن تكون رقم',

'Quantity_retail.required' => 'ادخل كمية التجزئة',
'Quantity_retail.numeric' => 'كمية التجزئة يجب أن تكون رقم',

'Quantity_all_retail.required' => 'ادخل الكمية الكلية بالتجزئة',
'Quantity_all_retail.numeric' => 'الكمية يجب أن تكون رقم',


        ];
    }
}
