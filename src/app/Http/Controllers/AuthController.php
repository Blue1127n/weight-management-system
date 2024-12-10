<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightManagementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showStep1()
{
    \Log::info('showStep1 メソッドが呼び出されました');
    return view('auth.register-step1');
}

public function storeStep1(Request $request)
{
    \Log::info('storeStep1 メソッドが呼び出されました');
    \Log::info('リクエストデータ:', $request->all());

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // パスワードをハッシュ化
    ]);

    // ユーザーをログイン状態にする
    auth()->login($user);

    // データ処理
    return redirect()->route('register.step2');
}

    public function showStep2()
    {
        \Log::info('showStep2 メソッドが呼び出されました');
        return view('auth.register-step2');
    }

    public function storeStep2(WeightManagementRequest $request)
{
    \Log::info('storeStep2 メソッドが呼び出されました');
    \Log::info('リクエストデータ:', $request->all());

    $validated = $request->validated(); // バリデーション済みデータを取得
    \Log::info('バリデーション成功:', $validated);

    // データを保存する
    $user = auth()->user();
    $user->weightTargets()->create([
        'target_weight' => $validated['target_weight'],
    ]);
    $user->weightLogs()->create([
        'date' => now(),
        'weight' => $validated['current_weight'],
    ]);

    // 体重管理画面へリダイレクト
    return redirect()->route('weight_logs');
}


    public function login(WeightManagementRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('weight_logs');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}