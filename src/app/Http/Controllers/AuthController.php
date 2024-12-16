<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showStep1()
{
    \Log::info('showStep1 メソッドが呼び出されました');
    return view('auth.register-step1');
}

public function storeStep1(RegisterRequest $request)
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

    public function storeStep2(AuthRequest $request)
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

public function login(LoginRequest $request)
{
    // デバッグ用ログ
    \Log::info('CSRFトークン:', ['token' => csrf_token()]);
    \Log::info('セッションID:', ['session_id' => session()->getId()]);
    \Log::info('セッションデータ（ログイン前）:', session()->all());

    Log::info('リクエストを受け取りました:', $request->all());

    $credentials = $request->only('email', 'password');
    Log::info('認証クレデンシャル:', $credentials);

    if (Auth::attempt($credentials)) {
        Log::info('認証成功', ['email' => $credentials['email']]);
        Log::info('ログインユーザー:', ['user' => Auth::user()->toArray()]);

        // セッションデータを確認
        Log::info('セッションID:', ['session_id' => session()->getId()]);
        Log::info('セッションデータ:', session()->all());

        return redirect()->route('weight_logs');
    } else {
        Log::error('認証失敗', ['email' => $credentials['email']]);
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);
    }
}

    public function logout(Request $request)
    {
        // ログアウト処理
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('ログアウトしました');
        return redirect()->route('login');
    }
}