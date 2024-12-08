<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightManagementRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showStep1()
    {
        return view('auth.register-step1');
    }

    public function storeStep1(WeightManagementRequest $request)
    {
        // ユーザーを作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ログイン状態にする
        auth()->login($user);

        return redirect()->route('register.step2');
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
