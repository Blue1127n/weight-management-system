<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightManagementRequest;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;

class AuthController extends Controller
{
    public function showStep1()
{
    \Log::info('showStep1 メソッドが呼び出されました');
    return view('auth.register-step1');
}

public function storeStep1(AuthRequest $request)
{
    \Log::info('storeStep1 メソッドが呼び出されました');
    \Log::info('リクエストデータ:', $request->all());

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
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


    // 現在の認証ユーザーを取得
    $user = auth()->user();

    // 目標体重を保存
    WeightTarget::create([
        'user_id' => $user->id,
        'target_weight' => $request->target_weight,
    ]);

    // 現在の体重を保存
    WeightLog::create([
        'user_id' => $user->id,
        'date' => now(),
        'weight' => $request->current_weight,
        'calories' => 0,
        'exercise_time' => '00:00:00',
        'exercise_content' => null,
    ]);

    return redirect()->route('weight_logs');
}

// ログイン
public function showLogin()
{
    \Log::info('showLogin メソッドが呼び出されました');
    return view('auth.login');
}

public function login(AuthRequest $request)
{
    \Log::info('セッションデータ（ログイン前）:', session()->all());
    \Log::info('現在の認証ユーザー:', ['user' => auth()->user()]);

    $credentials = $request->only('email', 'password');
    \Log::info('リクエストデータ:', $request->all());
    \Log::info('認証クレデンシャル:', $credentials);

    if (auth()->attempt($credentials)) {
        \Log::info('認証成功');
        \Log::info('ログインユーザーID:', ['user_id' => auth()->id()]);
        \Log::info('セッションデータ（ログイン後）:', session()->all());
        return redirect()->route('weight_logs');
    }

    \Log::error('認証失敗', ['credentials' => $credentials]);
    return back()->withErrors([
        'email' => 'メールアドレスまたはパスワードが正しくありません。',
    ]);
}

    public function logout()
    {
        \Log::info('ログアウト処理開始', ['user_id' => auth()->id()]);
        auth()->logout();
        \Log::info('ログアウト処理完了');
        return redirect()->route('login');
    }
}