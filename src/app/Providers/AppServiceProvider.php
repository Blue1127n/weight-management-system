<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 整数部分が4桁以内かチェック
        Validator::extend('valid_integer_part', function ($attribute, $value, $parameters, $validator) {
            \Log::info("valid_integer_part: {$attribute} = {$value}");
            return strlen((string)floor($value)) <= 4;
        });

        // 小数点以下が1桁以内かチェック
        Validator::extend('valid_decimal_part', function ($attribute, $value, $parameters, $validator) {
            \Log::info("valid_decimal_partバリデーションが実行されました。値: {$value}");
            if (!is_numeric($value)) {
                return false; // 数値以外は無効
            }

            if (strpos((string)$value, '.') !== false) {
                $decimals = strlen(substr(strrchr($value, '.'), 1));
                return $decimals <= 1;
            }
            return true; // 小数点がなければ問題なし
        });
    }
}
