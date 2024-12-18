<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TargetWeightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'target_weight' => [
                'required',
                'numeric',
                'valid_integer_part',
                'valid_decimal_part',
            ],
        ];
    }

    public function messages()
    {
        return [
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.valid_integer_part' => '4桁までの数字で入力してください',
            'target_weight.valid_decimal_part' => '小数点は1桁で入力してください',
            ];
    }

    public function failedValidation(Validator $validator)
    {
        \Log::error('バリデーションエラー詳細:', $validator->errors()->toArray());
        parent::failedValidation($validator);
    }
}
