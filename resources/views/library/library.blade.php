@extends('layout')

@section('title')
    Библиотека
@endsection

@section('main_content')
    <div class="sort_block" xmlns="http://www.w3.org/1999/html">
        <form class="sort" type="get" action="{{ route('library') }}">
            <span>Сортировать по</span>
            <div class="entry">
                <select name="sort_by">
                    <option @selected(session()->get('books_sort_type') == 'id') value="id"> ID</option>
                    <option @selected(session()->get('books_sort_type') == 'title') value="title">Название</option>
                    <option @selected(session()->get('books_sort_type') == 'genre') value="genre">Жанр</option>
                    <option @selected(session()->get('books_sort_type') == 'author') value="author">Автор</option>
                    <option @selected(session()->get('books_sort_type') == 'publisher') value="publisher">Издатель</option>
                    <option @selected(session()->get('books_sort_type') == 'edition') value="edition">Издание</option>
                </select>
            </div>
            <label>
                <input @checked(session()->get('reverse_books') == true) type="checkbox" name="reverse_books" value="true">
                <span>Обраная сортировка</span>
            </label>
            <div class="vertical_line"></div>
            <span>Искать по</span>
            <div class="entry">
                <select name="search_by">
                    <option @selected(session()->get('search_by') == 'id') value="id"> ID</option>
                    <option @selected(session()->get('search_by') == 'title') value="title">Название</option>
                    <option @selected(session()->get('search_by') == 'genre') value="genre">Жанр</option>
                    <option @selected(session()->get('search_by') == 'author') value="author">Автор</option>
                    <option @selected(session()->get('search_by') == 'publisher') value="publisher">Издатель</option>
                    <option @selected(session()->get('search_by') == 'edition') value="edition">Издание</option>
                </select>
            </div>
            <input type="text" name="search" value="{{ session()->get('search') }}">
            <button class="button" type="submit">Применить</button>
        </form>
    </div>
    <details class="form">
        <summary class="title">Список жанров</summary>
        <ul class="grid">
            @if($genres->isEmpty())
                <h3 class="title danger">Ни одного жанра не найдено</h3>
            @else
                @foreach($genres as $genre)
                    <li>{{ $genre->genre }}</li>
                @endforeach
            @endif
        </ul>
    </details>
    @if($books->isEmpty())
        <h3 class="title danger">Ничего не найдено</h3>
    @else
        <div class="list">
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
                    <span>Издатель: {{ $book->publisher }}</span>
                    <span class="date">Дата публикации: {{ $book->created_at->day }} {{ $book->created_at->englishMonth }} {{ $book->created_at->year }}</span>
                    <span class="gray">ID: {{ $book->id }}</span>
                </a>
            @endforeach
        </div>
        <div class="pagination">
            {{ $books->links() }}
        </div>
    @endif

@endsection
