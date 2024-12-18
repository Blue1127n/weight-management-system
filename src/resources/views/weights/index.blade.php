@extends('layouts.admin-layout')

@section('title', '体重管理画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-label">目標体重</div>
            <div class="stat-value">{{ $weightTarget ?? '-' }} <span class="unit">kg</span></div>
        </div>

    <div class="stat-divider"></div>
        <div class="stat-box">
            <div class="stat-label">目標まで</div>
                <div class="stat-value">
                    @if ($currentWeight && $weightTarget)
                        @php
                            $difference = $currentWeight - $weightTarget;
                        @endphp

                        @if ($difference < 0)
                            {{ number_format(abs($difference), 1) }}
                        @elseif ($difference == 0)
                            0
                        @else
                            -{{ number_format(abs($difference), 1) }}
                        @endif

                    @else
                        -
                    @endif
                    <span class="unit">kg</span></div>
                </div>

        <div class="stat-divider"></div>
                <div class="stat-box">
                    <div class="stat-label">最新体重</div>
                        <div class="stat-value">{{ $currentWeight ?? '-' }} <span class="unit">kg</span></div>
                    </div>
                </div>

    <div class="main-content">
        <div class="search-container">
            <form action="{{ route('weight_logs') }}" method="GET" class="search-form">
                <div class="search-fields">
                    <div class="input-container">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" placeholder="年/月/日">
                        <img src="{{ asset('images/Polygon.svg') }}" class="calendar-icon" alt="カレンダーアイコン">
                    </div>
                    <span class="date-separator">〜</span>
                    <div class="input-container">
                        <input type="date" name="end_date" value="{{ request('end_date') }}" placeholder="年/月/日">
                        <img src="{{ asset('images/Polygon.svg') }}" class="calendar-icon" alt="カレンダーアイコン">
                    </div>
                    <button type="submit" class="button search-button">検索</button>
                        @if(request('start_date') || request('end_date'))
                    <a href="{{ route('weight_logs') }}" class="button reset-button">リセット</a>
                        @endif
                </div>
            </form>
            <button class="button add-data-button" id="show-modal">データ追加</button>
        </div>

        <div class="search-result-info">
            <p class="search-conditions">
                {{ request('start_date') }} 〜 {{ request('end_date') }} の検索結果
                <span class="search-count">{{ $logs->total() }}件</span>
            </p>
        </div>

        <div class="results">
            @if ($logs->isNotEmpty())
                <table class="results-table">
                    <thead>
                        <tr>
                            <th class="column-date">日付</th>
                            <th class="column-weight">体重</th>
                            <th class="column-calories">摂取カロリー</th>
                            <th class="column-exercise">運動時間</th>
                            <th class="column-edit"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td class="cell-date">{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</td>
                            <td class="cell-weight">{{ $log->weight }} kg</td>
                            <td class="cell-calories">{{ $log->calories }} cal</td>
                            <td class="cell-exercise">{{ $log->exercise_time }}</td>
                            <td class="cell-edit">
                            <a href="{{ route('weight_logs.edit', $log->id) }}" class="edit-icon"><img src="{{ asset('images/pen.svg') }}" alt="編集" /></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pagination-container">
                    {{ $logs->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="index-modal hidden" id="index-modal">
    <div class="modal-content">
        <h2 class="modal-title">Weight Logを追加</h2>
        <form action="{{ route('weight_logs.store') }}" method="POST" autocomplete="off">
        @csrf

        <div class="form-group">
            <label for="date" class="label-with-required">日付<span class="required-label">必須</span></label>
                <div class="date-input-container">
                    <input type="date" id="date-field" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" placeholder="年/月/日" required>
                </div>
                @error('date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
        </div>

        <div class="form-group">
            <label for="weight" class="label-with-required">体重<span class="required-label">必須</span></label>
                <div class="input-with-unit">
                    <input type="text" id="weight-field" class="common-field" name="weight" step="0.1" value="{{ old('weight') }}" placeholder="50.0">
                    <span class="unit">kg</span>
                </div>
                @error('weight')
                    <p class="error-message">{{ $message }}</p>
                @enderror
        </div>

        <div class="form-group">
            <label for="calories" class="label-with-required">摂取カロリー<span class="required-label">必須</span></label>
                <div class="input-with-unit">
                    <input type="text" class="common-field" name="calories" value="{{ old('calories') }}" placeholder="1200">
                    <span class="unit">cal</span>
                </div>
                @error('calories')
                    <p class="error-message">{{ $message }}</p>
                @enderror
        </div>

        <div class="form-group">
            <label for="exercise_time" class="label-with-required">運動時間<span class="required-label">必須</span></label>
                <input type="time" id="exercise_time" name="exercise_time" value="{{ old('exercise_time') }}" placeholder="00:00">
                @error('exercise_time')
                    <p class="error-message">{{ $message }}</p>
                @enderror
        </div>

        <div class="form-group">
            <label for="exercise_content" class="label-with-required">運動内容</label>
                <textarea name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                @error('exercise_content')
                    <p class="error-message">{{ $message }}</p>
                @enderror
        </div>

        <div class="button-container">
            <button type="button" id="close-modal" class="button close-button">戻る</button>
            <button type="submit" class="button save-button">登録</button>
        </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const showModalButton = document.getElementById('show-modal');
    const modal = document.getElementById('index-modal');
    const closeModalButton = document.getElementById('close-modal');
    const modalForm = modal.querySelector('form');

    // セッションのopen_modalがある場合、モーダルを表示
    @if (session('open_modal'))
        modal.classList.remove('hidden');
    @endif

    // モーダル表示時の処理
    if (showModalButton && modal && modalForm) {
        showModalButton.addEventListener('click', () => {
            fetch("{{ route('clear_old_input') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            }).then(response => response.json()).then(data => {
                if (data.status === 'success') {
                    modalForm.reset();
                    modal.classList.remove('hidden');

                    // 日付フィールドに当日の日付を設定
                    const dateField = modalForm.querySelector('input[name="date"]');
                    if (dateField) {
                        const today = new Date();
                        const formattedDate = today.getFullYear() + '-' +
                            ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
                            ('0' + today.getDate()).slice(-2);
                        dateField.value = formattedDate; // YYYY-MM-DD形式
                    }
                }
            });
        });
    }

    // 「戻る」ボタンの処理
    if (closeModalButton && modal && modalForm) {
        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            modalForm.reset();
        });
    }
});

</script>
@endpush
