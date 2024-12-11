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
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力" autocomplete="email">
            @error('email')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" placeholder="パスワードを入力" autocomplete="current-password">
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


