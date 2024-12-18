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

    public function index(Request $request)
    {
        \Log::info('体重管理画面が表示されました');


        session()->forget('errors');

        if (!$request->session()->has('open_modal')) {
        session()->forget('_old_input');
        }

        $user = auth()->user();
        if (!$user) {
            \Log::error('認証ユーザーが取得できませんでした。');
            return redirect()->route('login')->withErrors('ログインしてください。');
        }

        $logs = $user->weightLogs()->orderBy('date', 'desc')->paginate(8);

        foreach ($logs as $log) {
        $log->exercise_time = Carbon::createFromFormat('H:i:s', $log->exercise_time)->format('H:i');
        }

        $currentWeight = $user->weightLogs()->latest('date')->value('weight');
        $weightTarget = $user->weightTarget()->value('target_weight');

        return view('weights.index', compact('logs', 'currentWeight', 'weightTarget'));
    }

    public function clearOldInput()
    {
        session()->forget('_old_input');
        return response()->json(['status' => 'success']);
    }

    public function create()
    {
    return view('weights.create');
    }

    public function store(WeightManagementRequest $request)
{
    try {
        auth()->user()->weightLogs()->create($request->validated());
        return redirect()->route('weight_logs')->with('success', '体重ログを登録しました。');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    }
}

    public function search(Request $request)
    {
        $user = auth()->user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $logs = $user->weightLogs()->whereBetween('date', [$startDate, $endDate])->paginate(8);

        return view('weights.index', compact('logs'));
    }

    public function edit($id)
    {
        $weightLog = WeightLog::findOrFail($id);
        $weightLog->exercise_time = Carbon::parse($weightLog->exercise_time)->format('H:i');

        return view('weights.edit', compact('weightLog'));
    }


    public function update(WeightManagementRequest $request, $weightLogId)
{
    \Log::info('送信された日付:', ['date' => $request->date]);

    $log = WeightLog::findOrFail($weightLogId);

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

    public function showGoalSetting()
    {
        $weightTarget = auth()->user()->weightTarget()->value('target_weight');
        \Log::info('目標体重:', ['target_weight' => $weightTarget]);
        return view('weights.goal', compact('weightTarget'));
    }

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