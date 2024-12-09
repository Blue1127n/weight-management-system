@extends('layouts.admin-layout')

@section('title', '目標体重変更画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/goal.css') }}">
@endpush

@section('content')
<div class="form-container">
    <form action="{{ route('weight_logs.set_goal') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="target_weight">目標体重</label>
            <input type="number" name="target_weight" step="0.1" value="{{ $weightTarget }}" required>
            <span class="unit">kg</span>
            @error('target_weight')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="buttons">
            <button type="submit" class="button update-button">更新</button>
            <a href="{{ route('weight_logs') }}" class="button back-button">戻る</a>
        </div>
    </form>
</div>
@endsection
