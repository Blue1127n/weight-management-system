@extends('layouts.admin-layout')

@section('title', '情報更新画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <h1 class="modal-title">Weight Log</h1>
    <form action="{{ route('weight_logs.update', $weightLog->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="date">日付</label>
            <input type="date" name="date" value="{{ $weightLog->date->format('Y-m-d') }}" placeholder="年/月/日">
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
            <textarea name="exercise_content">{{ $weightLog->exercise_content }} placeholder="運動内容を追加"</textarea>
            @error('exercise_content')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="buttons">
            <a href="{{ route('weight_logs') }}" class="button back-button">戻る</a>
            <button type="submit" class="button save-button">更新</button>
            <form action="{{ route('weight_logs.destroy', $weightLog->id) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">
                    <img src="{{ asset('images/trash.svg') }}" alt="削除" class="delete-icon">
                </button>
            </form>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForm = document.querySelector('.delete-form');
        deleteForm.addEventListener('submit', function (event) {
            if (!confirm('本当に削除しますか？')) {
                event.preventDefault();
            }
        });
    });
</script>
@endpush