<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\Request;
use App\Http\Requests\WeightManagementRequest;

class WeightController extends Controller
{
    // 体重ログ一覧画面の表示
    public function index(Request $request)
    {
        \Log::info('体重管理画面が表示されました');

        $user = auth()->user();
        $logs = $user->weightLogs()->orderBy('date', 'desc')->paginate(8);
        $currentWeight = $user->weightLogs()->latest('date')->value('weight');
        $weightTarget = $user->weightTarget()->value('target_weight');

        return view('weights.index', compact('logs', 'currentWeight', 'weightTarget'));
    }

    public function create()
{
    return view('weights.create'); // 新規登録用のviewファイル
}

    // 体重ログの登録
    public function store(WeightManagementRequest $request)
    {
        auth()->user()->weightLogs()->create($request->validated());

        return redirect()->route('weight_logs');
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
    public function edit($id)
    {
        $weightLog = WeightLog::findOrFail($id);
        return view('weights.edit', compact('weightLog'));
    }

    // 体重ログの更新
    public function update(WeightManagementRequest $request, $weightLogId)
    {
        $log = WeightLog::findOrFail($weightLogId);
        $log->update($request->validated());

        return redirect()->route('weight_logs');
    }

    // 体重ログの削除
    public function delete($weightLogId)
    {
        try {
        $log = WeightLog::findOrFail($weightLogId);
        $log->delete();

        return redirect()->route('weight_logs');
    } catch (\Exception $e) {
        \Log::error('体重ログの削除中にエラーが発生しました:', ['error' => $e->getMessage()]);
        return redirect()->route('weight_logs');
    }
    }

    // 目標体重設定画面の表示
    public function showGoalSetting()
    {
        $weightTarget = auth()->user()->weightTarget()->value('target_weight');

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

        return redirect()->route('weight_logs');
    }
}