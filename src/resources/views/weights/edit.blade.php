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
        <form action="{{ route('weight_logs.update', $weightLog->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="date">日付</label>
            <div class="input-with-icon">
            <input type="text" name="date" id="formatted-date" value="{{ old('date', \Carbon\Carbon::parse($weightLog->date)->toDateString()) }}" placeholder="年/月/日">
            <span class="triangle-icon">▼</span>
            </div>
            @error('date')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="weight">体重</label>
            <div class="input-with-unit">
                <input type="number" name="weight" value="{{ old('weight', $weightLog->weight) }}" step="0.1" placeholder="50.0">
                <span class="unit">kg</span>
            </div>
            @error('weight')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="calories">摂取カロリー</label>
            <div class="input-with-unit">
                <input type="number" name="calories" value="{{ old('calories', $weightLog->calories) }}" placeholder="1200" step="1" min="0">
                <span class="unit">cal</span>
            </div>
            @error('calories')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_time">運動時間</label>
            <input type="time" id="exercise-time" name="exercise_time" value="{{ old('exercise_time', $weightLog->exercise_time ?? '00:00') }}" placeholder="00:00">
            @error('exercise_time')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_content">運動内容</label>
            <textarea name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
            @error('exercise_content')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="button-group">
            <div class="center-buttons">
                <a href="{{ route('weight_logs') }}" class="button back-button">戻る</a>
                <button type="submit" class="button save-button">更新</button>
            </div>
        </div>
        </form>
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
</div>
@endsection

@push('scripts')
<!-- FlatpickrライブラリとCSS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('formatted-date');

    if (dateInput) {
        const flatpickrInstance = flatpickr(dateInput, {
            dateFormat: "Y年n月j日", // 表示は日本語形式
            locale: "ja",
            allowInput: true,
            defaultDate: new Date(dateInput.value), // 初期日付
            onClose: function (selectedDates) {
                if (selectedDates.length > 0) {
                    // 選択した日付をUTCから日本時間 (Asia/Tokyo) に調整
                    const offsetDate = new Date(selectedDates[0].getTime() - selectedDates[0].getTimezoneOffset() * 60000);
                    dateInput.value = offsetDate.toISOString().split('T')[0];
                }
            }
        });

        // フォーム送信時に Y-m-d 形式へ変換
        const form = dateInput.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                const selectedDate = flatpickrInstance.selectedDates[0];
                if (selectedDate) {
                    const offsetDate = new Date(selectedDate.getTime() - selectedDate.getTimezoneOffset() * 60000);
                    dateInput.value = offsetDate.toISOString().split('T')[0];
                }
            });
        }
    }

    // 運動時間が未入力の場合、デフォルト値を設定
    const timeInput = document.getElementById('exercise-time');
    if (timeInput) {
        const form = timeInput.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                if (!timeInput.value) {
                    timeInput.value = '00:00'; // 未入力時は00:00を設定
                }
            });
        }
    }

    // 削除ボタンの確認アラート
    const deleteForm = document.querySelector('.delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function (event) {
            if (!confirm('本当に削除しますか？')) {
                event.preventDefault();
            }
        });
    }
});
</script>

@endpush
