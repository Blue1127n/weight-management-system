@extends('layouts.admin-layout')

@section('title', '情報更新画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush

@section('content')
<div class="form-container">
    <form action="{{ route('weight_logs.update', $log->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="date">日付</label>
            <input type="date" name="date" value="{{ $log->date->format('Y-m-d') }}" required>
            @error('date')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="weight">体重</label>
            <input type="number" name="weight" step="0.1" value="{{ $log->weight }}" required>
            <span class="unit">kg</span>
            @error('weight')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="calories">摂取カロリー</label>
            <input type="number" name="calories" value="{{ $log->calories }}" required>
            <span class="unit">cal</span>
            @error('calories')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_time">運動時間</label>
            <input type="time" name="exercise_time" value="{{ $log->exercise_time }}" required>
            @error('exercise_time')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="exercise_content">運動内容</label>
            <textarea name="exercise_content">{{ $log->exercise_content }}</textarea>
            @error('exercise_content')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="buttons">
            <button type="submit" class="button update-button">更新</button>
            <a href="{{ route('weight_logs') }}" class="button back-button">戻る</a>
        </div>
    </form>
    <form action="{{ route('weight_logs.delete', $log->id) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="button delete-button">ゴミ箱</button>
    </form>
</div>
@endsection
