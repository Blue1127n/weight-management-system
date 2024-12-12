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
            <input type="number" name="target_weight" step="0.1" value="{{ $weightTarget }}" required>
            <span class="unit">kg</span>
            @error('target_weight')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="buttons">
            <button type="button" id="close-modal" class="button">戻る</button>
            <button type="submit" class="button update-button">更新</button>
        </div>
    </form>
</div>
@endsection
