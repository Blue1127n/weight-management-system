@extends('layouts.admin-layout')

@section('title', '目標体重変更画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/goal.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="form-container">
    <form action="{{ route('weight_logs.set_goal') }}" method="POST">
    @csrf

        <div class="form-group">
            <label for="target_weight">目標体重設定</label>
            <div class="input-group">
            <input type="number" name="target_weight" step="0.1" value="{{ $weightTarget }}" placeholder="46.5">
            <span class="unit">kg</span>
            </div>
            @error('target_weight')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="buttons">
            <button type="button" class="button button-close" onclick="history.back()">戻る</button>
            <button type="submit" class="button update-button">更新</button>
        </div>
    </form>
</div>
@endsection
