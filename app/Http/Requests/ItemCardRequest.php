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
            //

            'name' => 'required|string|max:255',

            'item_type' => 'required|in:1,2,3',

            'inv_itemscard_categories_id'
                => 'required|exists:inv_itemscard_categories,id',


            'parent_inv_itemscard_id'
                => 'nullable|exists:item_cards,id',


            'dose_has_retailunit' => 'nullable|in:0,1',


            'retail_uom'
                => 'nullable|string|max:255',


            'uom_id'
                => 'required|exists:inv_uoms,id',


            'retail_uom_quantity_to_parent'
                => 'nullable|numeric',


            'active'
                => 'required|in:0,1',
            'retail_price'
                => 'required',
            'wholesale_price'
                => 'required',
            'price'
                => 'nullable',


            'barcode'
                => 'nullable|string|max:255',


            'item_code'=> 'nullable|numeric',
            'nos_gomla_price' => 'nullable|numeric',
'nos_gomla_price_retail' => 'nullable|numeric',
'wholesale_price_retail' => 'nullable|numeric',
'coast_price' => 'nullable|numeric',
'coast_price_retail' => 'nullable|numeric',

'has_fixed_price' => 'nullable|in:0,1',

'Quantity' => 'nullable|numeric',
'Quantity_retail' => 'nullable|numeric',
'Quantity_all_retail' => 'nullable|numeric',

        ];
    }
     public function messages()
    {
        return [

            'name.required'
                =>'اسم الصنف مطلوب',


            'item_type.required'
                =>'نوع الصنف مطلوب',


            'item_type.in'
                =>'نوع الصنف غير صحيح',
            'retail_price.required'
                =>'ادخل سعر التجزئه',
            'wholesale_price.required'
                =>'ادخل سعر الجمله',
            'price.required'
                =>'ادخل السعر',


            'inv_itemscard_categories_id.required'
                =>'اختر فئة الصنف',


            'uom_id.required'
                =>'اختر وحدة القياس',


            'active.required'
                =>'حالة التفعيل مطلوبة',
            'dose_has_retailunit.required'
                =>'اختر فئة الصنف',


                'nos_gomla_price.required' => 'ادخل سعر النص جملة',
'nos_gomla_price.numeric' => 'سعر النص جملة يجب أن يكون رقم',

'nos_gomla_price_retail.required' => 'ادخل سعر النص جملة (تجزئة)',
'nos_gomla_price_retail.numeric' => 'سعر النص جملة يجب أن يكون رقم',

'wholesale_price_retail.required' => 'ادخل سعر الجملة (تجزئة)',
'wholesale_price_retail.numeric' => 'سعر الجملة يجب أن يكون رقم',

'coast_price.required' => 'ادخل سعر التكلفة',
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
