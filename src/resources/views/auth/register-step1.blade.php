@extends('layouts.auth-layout')

@section('title', '新規会員登録')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register-step1.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="form-container">
    <div class="logo-text">PiGLy</div>
    <div class="sub-title">新規会員登録</div>
        <p>STEP1 アカウント情報の登録</p>
    <form action="{{ route('register.step1') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">お名前</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="名前を入力">
            @error('name')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
            @enderror
        </div>

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

        <button type="submit">次に進む</button>
    </form>
    <a href="{{ route('login') }}">ログインはこちら</a>
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
        formContainer.style.height = '845px'; // 高さを手動でセット
    } else {
        console.log('エラーはありません');
        formContainer.classList.remove('has-errors');
        formContainer.style.height = '721px'; // 通常時の高さをリセット
    }
});
</script>
@endpush