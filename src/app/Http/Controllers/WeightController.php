<?php

namespace App\Http\Controllers;

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
        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => $request->target_weight,
        ]);

        // 現在の体重を WeightLog に保存
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

    // 体重ログ一覧画面の表示
    public function index(Request $request)
    {
        $user = auth()->user();
        $logs = $user->weightLogs()->orderBy('date', 'desc')->paginate(8);
        $currentWeight = $user->weightLogs()->latest('date')->value('weight');
        $weightTarget = $user->weightTargets()->value('target_weight');

        return view('weights.index', compact('logs', 'currentWeight', 'weightTarget'));
    }

    // 体重ログの登録
    public function store(WeightManagementRequest $request)
    {
        auth()->user()->weightLogs()->create($request->validated());

        return redirect()->route('weight_logs')->with('success', '体重ログが登録されました。');
    }

    // 検索機能
    public function search(Request $request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $logs = $user->weightLogs()->whereBetween('date', [$startDate, $endDate])->paginate(8);

        return view('weights.index', compact('logs'));
    }

    // 情報更新画面の表示
    public function show($weightLogId)
    {
        $log = WeightLog::findOrFail($weightLogId);
        return view('weights.edit', compact('log'));
    }

    // 体重ログの更新
    public function update(WeightManagementRequest $request, $weightLogId)
    {
        $log = WeightLog::findOrFail($weightLogId);
        $log->update($request->validated());

        return redirect()->route('weight_logs')->with('success', '体重ログが更新されました。');
    }

    // 体重ログの削除
    public function delete($weightLogId)
    {
        $log = WeightLog::findOrFail($weightLogId);
        $log->delete();

        return redirect()->route('weight_logs')->with('success', '体重ログが削除されました。');
    }

    // 目標体重設定画面の表示
    public function showGoalSetting()
    {
        $weightTarget = auth()->user()->weightTargets()->value('target_weight');

        return view('weights.goal', compact('weightTarget'));
    }

    // 目標体重の設定
    public function setGoal(WeightManagementRequest $request)
    {
        $user = auth()->user();
        WeightTarget::updateOrCreate(
            ['user_id' => $user->id],
            ['target_weight' => $request->target_weight]
        );

        return redirect()->route('weight_logs')->with('success', '目標体重が設定されました。');
    }
}