@extends('layout')

@section('title')
    Админ авторизация
@endsection

@section('main_content')
    <form method="post" action="{{ route('admin.login_check') }}" class="form">
        @csrf
        <h1>Админ авторизация</h1>
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
    </form>

@endsection
