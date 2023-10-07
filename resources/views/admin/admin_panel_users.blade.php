@extends('layout')

@section('title')
    Панель администратора
@endsection

@section('main_content')
    <a class="danger" href="{{ route('admin.logout') }}">Выйти</a>
    <a href="{{ route('admin.panel_books') }}">Книги</a>
    <a href="{{ route('admin.panel_logs') }}">Логи</a>
    <a class="here" href="{{ route('admin.panel_users') }}">Пользователи</a>
    <div class="sort_block">
        <form class="sort" type="get" action="{{ route('admin.panel_users') }}">
            <span>Сортировать по</span>
            <div class="entry">
                <select name="sort_by">
                    <option @selected(session()->get('users_sort_type') == 'id') value="id"> ID</option>
                    <option @selected(session()->get('users_sort_type') == 'login') value="login">Логин</option>
                    <option @selected(session()->get('users_sort_type') == 'email') value="email">Почта</option>
                    <option @selected(session()->get('users_sort_type') == 'usertag') value="usertag">Роль</option>
                </select>
            </div>
            <label>
                <input @checked(session()->get('reverse_users') == true) type="checkbox" name="reverse_users" value="true">
                <span>Обраная сортировка</span>
            </label>
            <div class="vertical_line"></div>
            <span>Искать по</span>
            <div class="entry">
                <select name="search_by">
                    <option @selected(session()->get('search_by') == 'id') value="id"> ID</option>
                    <option @selected(session()->get('search_by') == 'login') value="login">Логин</option>
                    <option @selected(session()->get('search_by') == 'email') value="email">Почта</option>
                    <option @selected(session()->get('search_by') == 'usertag') value="usertag">Роль</option>
                </select>
            </div>
            <input type="text" name="search" value="{{ session()->get('search') }}">
            <button class="button" type="submit">Применить</button>
        </form>
    </div>
    @if($users->isEmpty())
        <h3 class="title danger">Ничего не найдено</h3>
    @else
        <table class="admin_list">
            <tr>
                <td class="admin_list_id">ID</td>
                <td>Логин</td>
                <td>Почта</td>
                <td>Роль</td>
                <td>Дата регистрации</td>
                <td>Действия</td>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td class="admin_list_id">{{ $user->id }}</td>
                    <td><a href="{{ route('show_user', ['user' => $user->login]) }}">{{ $user->login }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->usertag }}</td>
                    <td>{{ $user->created_at->day }}.{{ $user->created_at->month }}.{{ $user->created_at->year }}</td>
                    <td>
                        <a href="{{ route('book', ['id' => $user->id]) }}">Перейти</a>
                        <a class="danger" href="{{ route('admin.delete_user', ['id' => $user->id]) }}">Удалить</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{ $users->links() }}
        </div>
    @endif


@endsection
