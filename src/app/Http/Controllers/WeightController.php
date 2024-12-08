<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use App\Http\Requests\WeightManagementRequest;

class WeightController extends Controller
{
    // 初期体重登録画面を表示
    public function showStep2()
    {
        return view('auth.register-step2');
    }

    // 初期体重を登録
    public function storeStep2(WeightManagementRequest $request)
    {
        $user = auth()->user();

        // 目標体重の保存
        WeightTarget::updateOrCreate(
            ['user_id' => $user->id],
            ['target_weight' => $request->target_weight]
        );

        // 現在の体重を WeightLog に保存
        WeightLog::create([
            'user_id' => $user->id,
            'date' => now(),
            'weight' => $request->current_weight,
            'calories' => 0, // 初期値（カロリー未設定）
            'exercise_time' => '00:00:00', // 初期値（運動時間未設定）
            'exercise_content' => null, // 初期値（運動内容未設定）
        ]);

        return redirect()->route('weight_logs');
    }

    // 体重ログの一覧を表示
    public function index()
    {
        $user = auth()->user();

        $weightLogs = $user->weightLogs()->orderBy('date', 'desc')->get();

        return view('weights.index', compact('weightLogs'));
    }

    // 体重ログを更新
    public function updateWeight(WeightManagementRequest $request, $id)
    {
        $weightLog = WeightLog::findOrFail($id);

        $weightLog->update($request->only('weight', 'calories', 'exercise_time', 'exercise_content'));

        return redirect()->route('weight_logs')->with('success', '体重ログを更新しました。');
    }

    // 目標体重を設定
    public function setGoal(WeightManagementRequest $request)
    {
        $user = auth()->user();

        WeightTarget::updateOrCreate(
            ['user_id' => $user->id],
            ['target_weight' => $request->target_weight]
        );

        return redirect()->route('weight_logs')->with('success', '目標体重を設定しました。');
    }
}