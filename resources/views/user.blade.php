@extends('layout')

@section('title')
    Страница пользователя
@endsection


@section('main_content')
    <div class="form">
        <p>ID: {{ $user->id }}</p>
        <h1>{{ $user->login }}</h1>
        <p>Почта: {{ $user->email }}</p>
        <p>Роль: {{ $user->usertag }}</p>
        @if(session()->get('login') == $user->login)
            <a href="{{ route('lk') }}">Перейти в личный кабинет</a>
        @endif
        @if($user->usertag == 'Издатель')
            <h2 class="title">Книги этого издателя</h2>
            <div class="sort_block">
                <form class="sort" type="get" action="{{ route('lk') }}">
                    <span>Сортировать по</span>
                    <div class="entry">
                        <select name="sort_by">
                            <option @selected(session()->get('books_sort_type') == 'id') value="id"> ID</option>
                            <option @selected(session()->get('books_sort_type') == 'title') value="title">Название</option>
                            <option @selected(session()->get('books_sort_type') == 'author') value="author">Автор</option>
                        </select>
                    </div>
                    <label style="display: flex; margin: 0 5px; align-items: center">
                        <input @checked(session()->get('reverse_books') == true) type="checkbox" name="reverse_books" value="true">
                        <span>Обраная сортировка</span>
                    </label>
                    <div class="vertical_line"></div>
                    <span>Искать по</span>
                    <div class="entry">
                        <select name="search_by">
                            <option @selected(session()->get('search_by') == 'id') value="id"> ID</option>
                            <option @selected(session()->get('search_by') == 'title') value="title">Название</option>
                            <option @selected(session()->get('search_by') == 'author') value="author">Автор</option>
                        </select>
                    </div>
                    <input type="text" name="search" value="{{ session()->get('search') }}">
                    <button class="button" type="submit">Применить</button>
                </form>
            </div>
            <div class="list lk">
                @if($books->isEmpty())
                    <h3 class="title danger">Ничего не найдено</h3>
                @else
                    @foreach($books as $book)
                        <a class="card" href="{{ route('book', ['id' => $book->id]) }}">
                            <div class="full_H">
                                <h2>{{ $book->title }}</h2>
                                <span>Автор: {{ $book->author }}</span>
                                <span>Жанр: {{ $book->genre }}</span>
                            </div>
                            @if($book->image != 'none')
                                <img src="{{ asset('/storage/' . $book->image) }}">
                            @else
                                <div class="img">
                                    <h3>{{ $book->title }}</h3>
                                    <h4>{{ $book->author }}</h4>
                                </div>
                            @endif
                            <p class="description">{{ $book->description }}</p>
                            <span class="date">Дата публикации: {{ $book->created_at->day }} {{ $book->created_at->englishMonth }} {{ $book->created_at->year }}</span>
                            <span class="gray">ID: {{ $book->id }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
            <div class="pagination">
                {{ $books->links() }}
            </div>
        @endif
    </div>
@endsection
