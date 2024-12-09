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
    <form action="{{ route('register.step2') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="current_weight">現在の体重</label>
            <input type="number" name="current_weight" step="0.1" value="{{ old('current_weight') }}" placeholder="現在の体重を入力">
            <span class="unit">kg</span>
            @error('current_weight')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="target_weight">目標の体重</label>
            <input type="number" name="target_weight" step="0.1" value="{{ old('target_weight') }}" placeholder="目標の体重を入力">
            <span class="unit">kg</span>
            @error('target_weight')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
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
    const errorMessages = document.querySelectorAll('.error span');

    console.log('フォームコンテナ:', formContainer);
    console.log('エラーメッセージ数:', errorMessages.length);

    if (formContainer && errorMessages.length > 0) {
        console.log('エラーが検出されました');
        formContainer.classList.add('has-errors');
        formContainer.style.height = '746px'; // 高さを手動でセット
    } else {
        console.log('エラーはありません');
        formContainer.classList.remove('has-errors');
        formContainer.style.height = '560px'; // 通常時の高さをリセット
    }
});
</script>
@endpush