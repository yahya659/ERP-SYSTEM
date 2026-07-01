<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoginRequest extends FormRequest
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
            'username'=>'required',
            'password'=>'required'
        ];

    }
    //  ؤساله اذا  المستخدم لم يدخل البيانات
    public function messages()
    {
        return[
            'username.required'=>'حقل الاااسم مطلوب ',
            'password.required'=>'حقل الرمز مطلوب',

        ];
    }
}
