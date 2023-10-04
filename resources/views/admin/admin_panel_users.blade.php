@extends('layout')

@section('title')
    Панель администратора
@endsection

@section('main_content')
    <a class="danger" href="{{ route('admin.logout') }}">Выйти</a>
    <a href="{{ route('admin.panel') }}">Книги</a>
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
            <label style="display: flex; margin: 0 5px; align-items: center">
                <input @checked(session()->get('reverse_users') == true) type="checkbox" name="reverse_users" value="true">
                <span style="font-size: 12pt">Обраная сортировка</span>
            </label>

            <button class="button" type="submit">Применить</button>
        </form>
        <form class="sort" type="get" action="{{ route('admin.panel_users') }}">
            <span style="margin-left: 30px">Искать по</span>
            <div class="entry">
                <select name="search_by">
                    <option @selected($search[0] == 'id') value="id"> ID</option>
                    <option @selected($search[0] == 'login') value="login">Логин</option>
                    <option @selected($search[0] == 'email') value="email">Почта</option>
                </select>
            </div>
            <input type="text" name="search" value="{{ $search[1] }}">
            <button class="button" type="submit">Поиск</button>
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
                    <td>{{ $user->login }}</td>
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
