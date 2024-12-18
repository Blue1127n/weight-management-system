<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理画面')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="logo">PiGLy</div>
        <nav class="nav">
            <a href="{{ route('weight_logs.goal_setting') }}" class="button goal-button">
                <img src="{{ asset('images/gear.svg') }}" alt="設定" class="icon">目標体重設定</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="button logout-button">
                <div class="logout-icon">
                    <img src="{{ asset('images/out1.svg') }}" alt="ドア" class="icon-layer door">
                    <img src="{{ asset('images/out2.svg') }}" alt="矢印" class="icon-layer arrow">
                    <img src="{{ asset('images/out3.svg') }}" alt="下線" class="icon-layer bottom">
                    <img src="{{ asset('images/out4.svg') }}" alt="逆線" class="icon-layer top">
                </div>
                ログアウト
            </button>
            </form>
        </nav>
    </header>
    <main class="main">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
