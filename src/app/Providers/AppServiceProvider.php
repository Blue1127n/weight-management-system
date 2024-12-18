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
        Validator::extend('valid_integer_part', function ($attribute, $value, $parameters, $validator) {
            \Log::info("valid_integer_part: {$attribute} = {$value}");
            $result = strlen((string)floor($value)) <= 4;
            \Log::info("valid_integer_part result: " . ($result ? 'Pass' : 'Fail'));
            return $result;
        });

        Validator::extend('valid_decimal_part', function ($attribute, $value, $parameters, $validator) {
            \Log::info("valid_decimal_partバリデーションが実行されました。値: {$value}");
            if (!is_numeric($value)) {
                \Log::info("Not a numeric value");
                return false;
            }
            if (strpos((string)$value, '.') !== false) {
                $decimals = strlen(substr(strrchr($value, '.'), 1));
                \Log::info("小数点以下の桁数: {$decimals}");
                $result = $decimals <= 1;
                \Log::info("valid_decimal_part result: " . ($result ? 'Pass' : 'Fail'));
                return $result;
            }
            return true;
        });
    }
}
