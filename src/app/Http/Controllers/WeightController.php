<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use App\Http\Requests\TargetWeightRequest;
use Illuminate\Http\Request;
use App\Http\Requests\WeightManagementRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WeightController extends Controller
{
    // 体重ログ一覧画面の表示
    public function index(Request $request)
    {
        \Log::info('体重管理画面が表示されました');

        // セッションエラーをクリア
        session()->forget('errors');

       // 古い入力データをクリア（新規モーダル表示用）
        if (!$request->session()->has('open_modal')) {
        session()->forget('_old_input');
        }

        $user = auth()->user();
        if (!$user) {
            \Log::error('認証ユーザーが取得できませんでした。');
            return redirect()->route('login')->withErrors('ログインしてください。');
        }

        // ログインユーザーの体重ログを取得
        $logs = $user->weightLogs()->orderBy('date', 'desc')->paginate(8);

        // 運動時間を H:i 形式に変換する
        foreach ($logs as $log) {
        $log->exercise_time = Carbon::createFromFormat('H:i:s', $log->exercise_time)->format('H:i');
        }

        // 最新体重と目標体重を取得
        $currentWeight = $user->weightLogs()->latest('date')->value('weight');
        $weightTarget = $user->weightTarget()->value('target_weight');

        return view('weights.index', compact('logs', 'currentWeight', 'weightTarget'));
    }

    public function clearOldInput(Request $request)
    {
        session()->forget('_old_input'); // 古い入力データをクリア
        return response()->json(['status' => 'success']);
    }

    public function create()
    {
    return view('weights.create'); // 新規登録用のviewファイル
    }


    // 体重ログの登録
    public function store(WeightManagementRequest $request)
{
    try {
        auth()->user()->weightLogs()->create($request->validated());
        return redirect()->route('weight_logs')->with('success', '体重ログを登録しました。');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    }
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
        $weightLog->exercise_time = Carbon::parse($weightLog->exercise_time)->format('H:i');
    
        return view('weights.edit', compact('weightLog'));
    }

    // 体重ログの更新
    public function update(WeightManagementRequest $request, $weightLogId)
{
    \Log::info('送信された日付:', ['date' => $request->date]);

    $log = WeightLog::findOrFail($weightLogId);

    // 送信された日付をAsia/Tokyoタイムゾーンで処理
    $date = Carbon::createFromFormat('Y-m-d', $request->date, 'Asia/Tokyo')
                ->toDateString();

    $log->update([
        'date' => $date,
        'weight' => $request->weight,
        'calories' => $request->calories,
        'exercise_time' => $request->exercise_time,
        'exercise_content' => $request->exercise_content,
    ]);

    return redirect()->route('weight_logs')->with('success', 'データを更新しました。');
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
        \Log::info('目標体重:', ['target_weight' => $weightTarget]); // デバッグログ
        return view('weights.goal', compact('weightTarget'));
    }

    // 目標体重の設定
    public function setGoal(TargetWeightRequest $request)
    {
        \Log::info('リクエストデータ:', $request->all());
        $user = auth()->user();
        WeightTarget::updateOrCreate(
            ['user_id' => $user->id],
            ['target_weight' => $request->target_weight]
        );

        \Log::info('目標体重が更新されました:', ['target_weight' => $request->target_weight]);

        return redirect()->route('weight_logs');
    }
}