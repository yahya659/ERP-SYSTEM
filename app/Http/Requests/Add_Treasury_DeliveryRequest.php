<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class Add_Treasury_DeliveryRequest extends FormRequest
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
            'treasuries_can_delivery_id'=>'required'
            //
        ];
    }
        public function messages()
    {
        return [
        'treasuries_can_delivery_id'=>'يرجاء اختيار الخزنه لفرعيه'
        ];
    }
}

