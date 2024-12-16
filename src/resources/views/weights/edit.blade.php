@extends('layouts.admin-layout')

@section('title', '情報更新画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="container">
<div class="edit-container">
    <h2 class="container-title">Weight Log</h2>
    <form action="{{ route('weight_logs.update', $weightLog->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="date">日付</label>
            <div class="input-with-icon">
            <input type="text" name="date" id="formatted-date" value="{{ $weightLog->date->format('Y年n月j日') }}" placeholder="年/月/日">
            <span class="triangle-icon">▼</span>
            </div>
            @error('date')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="weight">体重</label>
            <div class="input-with-unit">
                <input type="number" name="weight" value="{{ $weightLog->weight }}" step="0.1" placeholder="50.0">
                <span class="unit">kg</span>
            </div>
            @error('weight')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="calories">摂取カロリー</label>
            <div class="input-with-unit">
                <input type="number" name="calories" value="{{ $weightLog->calories }}" placeholder="1200">
                <span class="unit">cal</span>
            </div>
            @error('calories')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_time">運動時間</label>
            <input type="time" name="exercise_time" value="{{ $weightLog->exercise_time }}" placeholder="00：00">
            @error('exercise_time')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_content">運動内容</label>
            <textarea name="exercise_content" placeholder="運動内容を追加">{{ $weightLog->exercise_content }}</textarea>
            @error('exercise_content')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="button-group">
        <div class="center-buttons">
            <a href="{{ route('weight_logs') }}" class="button back-button">戻る</a>
            <button type="submit" class="button save-button">更新</button>
</div>
            <form action="{{ route('weight_logs.destroy', $weightLog->id) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">
    <div class="trash-icon-wrapper">
    <img src="{{ asset('images/trash.svg') }}" alt="ゴミ箱のベース" class="delete-icon base-trash">
        <img src="{{ asset('images/trash1.svg') }}" alt="ゴミ箱のフタ" class="delete-icon overlay-trash">
                    </div>
                </button>
            </form>
        </div>
    </form>
    </div>
    </div>
@endsection

@push('scripts')
<!-- FlatpickrライブラリとCSS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 削除確認アラート
        const deleteForm = document.querySelector('.delete-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function (event) {
                if (!confirm('本当に削除しますか？')) {
                    event.preventDefault();
                }
            });
        }

        // Flatpickrによる日付入力のカスタマイズ
        const dateInput = document.getElementById('formatted-date');
        if (dateInput) {
            flatpickr(dateInput, {
                dateFormat: "Y年n月j日", // 日本語形式での表示
                locale: "ja", // 日本語ロケール
                allowInput: true // 手動入力を許可
            });
        }
    });
</script>
@endpush
