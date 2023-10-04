@extends('layout')

@section('title')
    Панель администратора
@endsection

@section('main_content')
    <a class="danger" href="{{ route('admin.logout') }}">Выйти</a>
    <a class="here" href="{{ route('admin.panel_books') }}">Книги</a>
    <a href="{{ route('admin.panel_logs') }}">Логи</a>
    <a href="{{ route('admin.panel_users') }}">Пользователи</a>
    <div class="sort_block">
        <form class="sort" type="get" action="{{ route('admin.panel_books') }}">
            <span>Сортировать по</span>
            <div class="entry">
                <select name="sort_by">
                    <option @selected(session()->get('books_sort_type') == 'id') value="id"> ID</option>
                    <option @selected(session()->get('books_sort_type') == 'title') value="title">Название</option>
                    <option @selected(session()->get('books_sort_type') == 'author') value="author">Автор</option>
                    <option @selected(session()->get('books_sort_type') == 'publisher') value="publisher">Издатель</option>
                </select>
            </div>
            <label style="display: flex; margin: 0 5px; align-items: center">
                <input @checked(session()->get('reverse_books') == true) type="checkbox" name="reverse_books" value="true">
                <span style="font-size: 12pt">Обраная сортировка</span>
            </label>

            <button class="button" type="submit">Применить</button>
        </form>
        <form class="sort" type="get" action="{{ route('admin.panel_books') }}">
            <span style="margin-left: 30px">Искать по</span>
            <div class="entry">
                <select name="search_by">
                    <option @selected($search[0] == 'id') value="id"> ID</option>
                    <option @selected($search[0] == 'title') value="title">Название</option>
                    <option @selected($search[0] == 'author') value="author">Автор</option>
                    <option @selected($search[0] == 'publisher') value="publisher">Издатель</option>
                </select>
            </div>
            <input type="text" name="search" value="{{ $search[1] }}">
            <button class="button" type="submit">Поиск</button>
        </form>
    </div>
    @if($books->isEmpty())
        <h3 class="title danger">Ничего не найдено</h3>
    @else
        <table class="admin_list">
            <tr>
                <td class="admin_list_id">ID</td>
                <td>Название</td>
                <td>Автор</td>
                <td>Издатель</td>
                <td>Издание</td>
                <td>Жанр</td>
                <td>Дата публикации</td>
                <td>Действия</td>
            </tr>
            @foreach($books as $book)
                <tr>
                    <td class="admin_list_id">{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ $book->edition }}</td>
                    <td>{{ $book->genre }}</td>
                    <td>{{ $book->created_at->day }}.{{ $book->created_at->month }}.{{ $book->created_at->year }}</td>
                    <td>
                        <a href="{{ route('book', ['id' => $book->id]) }}">Открыть</a>
                        <a href="{{ route('admin.edit', ['id' => $book->id]) }}">Редактировать</a>
                        <a class="danger" href="{{ route('admin.delete_book', ['id' => $book->id]) }}">Удалить</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{ $books->links() }}
        </div>
    @endif
@endsection
