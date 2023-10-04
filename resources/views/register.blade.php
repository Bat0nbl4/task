@extends('layout')

@section('title')
    {{ isset($user) ? 'Редактирование пользователя' : 'Регистрация' }}
@endsection

@section('main_content')
    <form method="post" action="{{ isset($user) ? route('admin.user_update') : route('register_check') }}" class="form">
        @csrf

        @if(isset($user))
            @method('PUT')
            <input hidden type="text" name="id" id="id" value="{{ $user->id }}">
        @endif

        <h1>{{ isset($user) ? 'Редактирование пользователя' : 'Регистрация' }}</h1>
        <div class="entry">
            <input value="{{ isset($user) ? $user->email : '' }}" type="email" name="email" id="email" placeholder="Почта">
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="entry">
            <input value="{{ isset($user) ? $user->login : '' }}" type="text" name="login" id="login" placeholder="Логин">
            @error('login')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        @if(!isset($user))
            <div class="entry">
                <select name="usertag" id="usertag">
                    @foreach(\App\Enums\UserTags::cases() as $key => $label)
                        <option value="{{ $label->value }}">{{ $label->value }}</option>
                    @endforeach
                </select>
                @error('usertag')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
        @endif
        @if(!isset($user))
            <div class="entry">
                <input type="password" name="password" id="password" placeholder="Пароль">
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="entry">
                <input type="password" name="password_confirmation" id="repead_password" placeholder="Повтор пароля">
                @error('password_confirmation')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <button type="submit" class="button full_w">{{ isset($user) ? 'Подтвердить' : 'Регистрация' }}</button>
        @if(!isset($user))
            <div style="margin-top: 20px">
                <span>Уже есть аккаунт? <a href="{{ 'login' }}">Войти</a></span>
            </div>
        @endif


    </form>
@endsection
