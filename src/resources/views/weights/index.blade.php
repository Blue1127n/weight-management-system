@extends('layouts.admin-layout')

@section('title', '体重管理画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="stats">
    <div class="stat">
        <div class="stat-label">目標体重</div>
        <div class="stat-value">{{ $weightTarget ?? '-' }} kg</div>
    </div>
    <div class="stat">
        <div class="stat-label">目標まで</div>
        <div class="stat-value">{{ $currentWeight && $weightTarget ? $currentWeight - $weightTarget : '-' }} kg</div>
    </div>
    <div class="stat">
        <div class="stat-label">最新体重</div>
        <div class="stat-value">{{ $currentWeight ?? '-' }} kg</div>
    </div>
</div>

<div class="search-container">
    <form action="{{ route('weight_logs') }}" method="GET">
        <input type="date" name="start_date" value="{{ request('start_date') }}">
        <span>〜</span>
        <input type="date" name="end_date" value="{{ request('end_date') }}">
        <button type="submit" class="button search-button">検索</button>
        <a href="{{ route('weight_logs') }}" class="button reset-button">リセット</a>
    </form>
</div>

<div class="results">
    @if ($logs->isNotEmpty())
        <table class="results-table">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>体重</th>
                    <th>摂取カロリー</th>
                    <th>運動時間</th>
                    <th>編集</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->date->format('Y/m/d') }}</td>
                    <td>{{ $log->weight }} kg</td>
                    <td>{{ $log->calories }} cal</td>
                    <td>{{ $log->exercise_time }}</td>
                    <td>
                        <a href="{{ route('weight_logs.update', $log->id) }}" class="edit-icon">✎</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $logs->links('pagination::bootstrap-4') }}
    @else
        <p>検索結果がありません。</p>
    @endif
</div>

<button class="button add-data-button" id="show-modal">データ追加</button>
<div class="modal" id="data-modal" style="display: none;">
    <div class="modal-content">
        <form action="{{ route('weight_logs.store') }}" method="POST">
            @csrf
            <label for="date">日付</label>
            <input type="date" name="date" value="{{ now()->format('Y-m-d') }}" required>
            <label for="weight">体重</label>
            <input type="number" name="weight" step="0.1" required>
            <label for="calories">摂取カロリー</label>
            <input type="number" name="calories" required>
            <label for="exercise_time">運動時間</label>
            <input type="time" name="exercise_time" required>
            <label for="exercise_content">運動内容</label>
            <textarea name="exercise_content"></textarea>
            <button type="submit" class="button">登録</button>
            <button type="button" class="button close-modal">戻る</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showModalButton = document.getElementById('show-modal');
        const modal = document.getElementById('data-modal');
        const closeModalButton = document.querySelector('.close-modal');

        if (showModalButton && modal && closeModalButton) {
            showModalButton.addEventListener('click', () => {
                modal.style.display = 'block';
            });

            closeModalButton.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        } else {
            console.error('モーダルまたはボタンが見つかりません');
        }
    });
</script>
@endpush
