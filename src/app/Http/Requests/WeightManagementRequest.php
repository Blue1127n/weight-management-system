<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string',
            'current_weight' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (strlen((string)floor($value)) > 4) {
                        $fail('4桁までの数字で入力してください');
                    }
                    if (strpos((string)$value, '.') !== false) {
                        $decimals = strlen(substr(strrchr($value, '.'), 1));
                        if ($decimals > 1) {
                            $fail('小数点は1桁で入力してください');
                        }
                    }
                },
            ],
            'target_weight' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (strlen((string)floor($value)) > 4) {
                        $fail('4桁までの数字で入力してください');
                    }
                    if (strpos((string)$value, '.') !== false) {
                        $decimals = strlen(substr(strrchr($value, '.'), 1));
                        if ($decimals > 1) {
                            $fail('小数点は1桁で入力してください');
                        }
                    }
                },
            ],
            'date' => 'required|date',
            'weight' => 'required|numeric|between:0,999.9',
            'calories' => 'required|integer|min:0|max:9999',
            'exercise_time' => 'required|date_format:H:i',
            'exercise_content' => 'nullable|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'current_weight.required' => '現在の体重を入力してください',
            'target_weight.required' => '目標の体重を入力してください',
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数値で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}

