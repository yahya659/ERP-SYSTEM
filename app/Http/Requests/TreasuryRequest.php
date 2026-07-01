<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class TreasuryRequest extends FormRequest
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
            'name' => 'required|unique:treasuries,name,' . $this->route('id'),//عند التعديل لو ماتشتي تعدل الااسم مايعدله
            'is_master'=>'required',
            'active'=>'required|in:0,1',
            'last_isal_exchange'=>'nullable',
            'last_isal_collection'=>'nullable',


        ];

    }
    //  ؤساله اذا  المستخدم لم يدخل البيانات
    public function messages()
    {
        return[
            'name.required'=>'حقل الاسم مطلوب ',
            'name.unique' => 'اسم الخزنة موجود مسبقاً، الرجاء إدخال اسم آخر',
            'is_master.required'=>'حقل المخزن الرئيسي مطلوب',
            'active.required'=>'حقل الحالة مطلوب',
            'active.in'=>'حقل الحالة يجب ان يكون 0 او 1',



        ];
    }
}
