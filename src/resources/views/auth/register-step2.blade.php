@extends('layouts.auth-layout')

@section('title', '新規会員登録 - STEP2')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register-step2.css') }}">
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
            <input type="number" name="current_weight" step="0.1" placeholder="現在の体重を入力">
            @error('current_weight')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="target_weight">目標の体重</label>
            <input type="number" name="target_weight" step="0.1" placeholder="目標の体重を入力">
            @error('target_weight')
            <div class="error">
                <span>{{ $message }}</span>
            </div>
            @enderror
        </div>

        <button type="submit">アカウント作成</button>
    </form>
</div>
@endsection
