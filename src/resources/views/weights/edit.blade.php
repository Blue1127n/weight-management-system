@extends('layouts.admin-layout')

@section('title', '情報更新画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<!-- モーダルを開くボタン -->
<button id="open-modal" class="button add-data-button">データ追加</button>

<!-- モーダル -->
<div id="data-modal" class="modal hidden">
    <div class="modal-content">
        <h1 class="modal-title">Weight Logを追加</h1>
        <form action="{{ route('weight_logs.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="date">日付 <span class="required">必須</span></label>
            <input type="date" name="date" value="{{ now()->format('Y-m-d') }}" placeholder="年/月/日">
            @error('date')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="weight">体重 <span class="required">必須</span></label>
            <div class="input-with-unit">
            <input type="number" name="weight" step="0.1" placeholder="50.0">
                <span class="unit">kg</span>
            </div>
            @error('weight')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="calories">摂取カロリー <span class="required">必須</span></label>
            <div class="input-with-unit">
            <input type="number" name="calories" placeholder="1200">
                <span class="unit">cal</span>
            </div>
            @error('calories')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_time">運動時間 <span class="required">必須</span></label>
            <input type="time" name="exercise_time" placeholder="00：00">
            @error('exercise_time')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_content">運動内容</label>
            <textarea name="exercise_content" placeholder="運動内容を追加"></textarea>
            @error('exercise_content')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="buttons">
            <button type="button" id="close-modal" class="button">戻る</button>
            <button type="submit" class="button save-button">登録</button>
        </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('show-modal').addEventListener('click', function () {
    document.getElementById('data-modal').classList.remove('hidden');
});

document.getElementById('close-modal').addEventListener('click', function () {
    document.getElementById('data-modal').classList.add('hidden');
});
</script>
@endpush
