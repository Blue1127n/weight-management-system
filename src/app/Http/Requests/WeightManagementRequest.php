<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WeightManagementRequest extends FormRequest
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
        \Log::info('WeightManagementRequestのバリデーションが実行されました。');
        return [
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    \Log::info("送信された日付: {$value}");
                    if ($value === now()->format('Y-m-d')) {
                        $fail('日付を入力してください');
                    }
                },
            ],
            'weight' => [
            'required',
            'numeric',
            'valid_integer_part',
            'valid_decimal_part',
            ],
            'calories' => 'required|integer|min:0|max:9999',
            'exercise_time' => 'required|date_format:H:i',
            'exercise_content' => 'nullable|string|max:120',
            ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'weight.valid_integer_part' => '4桁までの数字で入力してください',
            'weight.valid_decimal_part' => '小数点は1桁で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.max' => '120文字以内で入力してください',
            ];
    }

    public function failedValidation(Validator $validator)
    {
        \Log::error('バリデーションエラー詳細:', $validator->errors()->toArray());
        parent::failedValidation($validator);
    }
}

