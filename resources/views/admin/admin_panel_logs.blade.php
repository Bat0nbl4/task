@extends('layout')

@section('title')
    Панель администратора
@endsection

@section('main_content')
    <a class="danger" href="{{ route('admin.logout') }}">Выйти</a>
    <a href="{{ route('admin.panel_books') }}">Книги</a>
    <a class="here" href="{{ route('admin.panel_logs') }}">Логи</a>
    <a href="{{ route('admin.panel_users') }}">Пользователи</a>
    <div class="sort_block">
        <form class="sort" type="get" action="{{ route('admin.panel_logs') }}">
            <span>Сортировать по</span>
            <div class="entry">
                <select name="sort_by">
                    <option @selected(session()->get('logs_sort_type') == 'id') value="id"> ID</option>
                    <option @selected(session()->get('logs_sort_type') == 'book_id') value="book_id">ID книги</option>
                    <option @selected(session()->get('logs_sort_type') == 'title') value="title">Название</option>
                    <option @selected(session()->get('logs_sort_type') == 'author') value="author">Автор</option>
                    <option @selected(session()->get('logs_sort_type') == 'publisher') value="publisher">Издатель</option>
                    <option @selected(session()->get('logs_sort_type') == 'genre') value="genre">Жанр</option>
                    <option @selected(session()->get('logs_sort_type') == 'edition') value="edition">Издание</option>
                </select>
            </div>
            <label style="display: flex; margin: 0 5px; align-items: center">
                <input @checked(session()->get('reverse_logs') == true) type="checkbox" name="reverse_logs" value="true">
                <span style="font-size: 12pt">Обраная сортировка</span>
            </label>

            <button class="button" type="submit">Применить</button>
        </form>
        <form class="sort" type="get" action="{{ route('admin.panel_logs') }}">
            <span style="margin-left: 30px">Искать по</span>
            <div class="entry">
                <select name="search_by">
                    <option @selected($search[0] == 'id') value="id"> ID</option>
                    <option @selected($search[0] == 'book_id') value="book_id">ID книги</option>
                    <option @selected($search[0] == 'title') value="title">Название</option>
                    <option @selected($search[0] == 'author') value="author">Автор</option>
                    <option @selected($search[0] == 'publisher') value="publisher">Издатель</option>
                    <option @selected($search[0] == 'genre') value="genre">Жанр</option>
                    <option @selected($search[0] == 'edition') value="edition">Издание</option>
                </select>
            </div>
            <input type="text" name="search" value="{{ $search[1] }}">
            <button class="button" type="submit">Поиск</button>
        </form>
    </div>
    @if($logs->isEmpty())
        <h3 class="title danger">Ничего не найдено</h3>
    @else
        <table class="admin_list">
            <tr>
                <td class="admin_list_id">ID</td>
                <td class="admin_list_id">ID книги</td>
                <td>Название</td>
                <td>Автор</td>
                <td>Жанр</td>
                <td>Издатель</td>
                <td>Издание</td>
                <td>Дата</td>
            </tr>
            @foreach($logs as $log)
                <tr>
                    <td class="admin_list_id">{{ $log->id }}</td>
                    <td class="admin_list_id">{{ $log->book_id }}</td>
                    <td>{{ $log->title }}</td>
                    <td>{{ $log->author }}</td>
                    <td>{{ $log->genre }}</td>
                    <td>{{ $log->publisher }}</td>
                    <td>{{ $log->edition }}</td>
                    <td>{{ $log->created_at->day }}.{{ $log->created_at->month }}.{{ $log->created_at->year }} {{ $log->created_at->hour }}:{{ $log->created_at->minute }}</td>
                </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{ $logs->links() }}
        </div>
    @endif


@endsection
