<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理画面')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="logo">PiGLy</div>
        <nav class="nav">
            <a href="{{ route('weight_logs.goal_setting') }}" class="button">目標体重設定</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="button">ログアウト</button>
            </form>
        </nav>
    </header>
    <main class="main">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
