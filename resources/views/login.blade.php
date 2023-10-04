@extends('layout')

@section('title')
    Авторизация
@endsection

@section('main_content')
    <form method="post" action="{{ route('login_check') }}" class="form">
        @csrf
        <h1>Авторизация</h1>
        <div class="entry">
            <input type="text" name="login" id="login" placeholder="Логин">
            @error('login')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="entry">
            <input type="password" name="password" id="password" placeholder="Пароль">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="button full_w">Войти</button>
        <div style="margin-top: 20px">
            <span>Нет аккаунта? <a href="{{ route('register') }}">Создать</a></span>
            @guest('admin')
                <span><a href="{{ route('admin.login') }}">Войти как администратор</a></span>
            @endguest
        </div>

    </form>

@endsection
