@extends('layouts.auth-layout')

@section('title', '新規会員登録 - STEP2')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register-step2.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="form-container">
    <div class="logo-text">PiGLy</div>
    <div class="sub-title">新規会員登録</div>
    <p>STEP2 体重データの入力</p>
    <form action="{{ route('register.step2') }}" method="POST" novalidate>
        @csrf

        <div class="form-group">
            <label for="current_weight">現在の体重</label>
            <input type="text" id="current_weight" name="current_weight" value="{{ old('current_weight') }}" placeholder="現在の体重を入力">
            <span class="unit">kg</span>
            @error('current_weight')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="target_weight">目標の体重</label>
            <input type="text" id="target_weight" name="target_weight" value="{{ old('target_weight') }}" placeholder="目標の体重を入力">
            <span class="unit">kg</span>
            @error('target_weight')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="button">アカウント作成</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formContainer = document.querySelector('.form-container');
        const errorMessages = document.querySelectorAll('.form-container .error-message');

        // 初期高さを設定
        if (formContainer) {
            formContainer.style.height = '560px';
        }

        // エラーメッセージがある場合に高さを拡張
        if (errorMessages.length > 0 && formContainer) {
            formContainer.style.height = '746px';
        }
    });
</script>
@endpush