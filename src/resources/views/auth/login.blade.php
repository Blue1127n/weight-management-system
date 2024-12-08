@extends('layouts.auth-layout')

@section('title', 'ログイン')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="form-container">
    <div class="logo-text">PiGLy</div>
    <div class="sub-title">ログイン</div>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">
            @error('email')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password" placeholder="パスワードを入力">
            @error('password')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
            @enderror
        </div>

        <button type="submit" class="login-button">ログイン</button>
    </form>
    <a href="{{ route('register.step1') }}" class="register-link">アカウント作成はこちら</a>
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
            formContainer.style.height = '653px'; // エラー時の高さを設定
        } else {
            console.log('エラーはありません');
            formContainer.style.height = '560px'; // 通常時の高さを設定
        }
    });
</script>
@endpush

