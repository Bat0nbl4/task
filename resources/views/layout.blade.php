<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?t={{ time() }}">
</head>
<body>
<header @if(session()->has('admin_login')) class="admin_header" @endif>
    <div class="head">
        <a href="{{ route('home') }}"><h2>TASK</h2></a>
        <nav>
            <a href="{{ route('library') }}">Библиотека</a>
            @auth('admin')
                <a href="{{ route('admin.panel_books') }}" class="login-btn"><?php echo session()->get('admin_login')?></a>
            @endauth
            @auth('web')
                <a href="{{ route('lk') }}" class="login-btn"><?php echo session()->get('login')?></a>
            @endauth
            @guest('web')
                <a href="{{ route('login') }}" class="login-btn">Войти</a>
            @endguest
        </nav>
    </div>
</header>
<div class="main_content">
    @yield("main_content")
</div>
<footer>
    footer
    <pre>
        {{ print_r(session()->all()) }}
    </pre>
</footer>


</body>
</html>
