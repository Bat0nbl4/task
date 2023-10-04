@extends('layout')

@section('title')
    Библиотека
@endsection

@section('main_content')
    <div class="sort_block">
        <form class="sort" type="get" action="{{ route('library') }}">
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
        <form class="sort" type="get" action="{{ route('library') }}">
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
    <div class="list">
        @foreach($books as $book)
            <a class="card" href="{{ route('book', ['id' => $book->id]) }}">
                <div class="full_H">
                    <h2>{{ $book->title }}</h2>
                    <p>Автор: {{ $book->author }}</p>
                    @if($book->image != 'none')
                        <img src="{{ asset('/storage/' . $book->image) }}">
                    @else
                        <div class="img">
                            <h3>{{ $book->title }}</h3>
                            <h4>{{ $book->author }}</h4>
                        </div>
                    @endif

                    <p class="description">{{ $book->description }}</p>
                </div>
                <span>Издатель: {{ $book->publisher }}</span>
                <span class="date">Дата публикации: {{ $book->created_at->day }} {{ $book->created_at->englishMonth }} {{ $book->created_at->year }}</span>
                <span class="gray">ID: {{ $book->id }}</span>
            </a>
        @endforeach
    </div>
    <div class="pagination">
        {{ $books->links() }}
    </div>
@endsection
