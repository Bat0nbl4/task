@extends('layout')

@section('title')
    Главная
@endsection

@section('main_content')
    <h1 align="center">Последние релизы</h1>
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
                <span class="date">Дата публикации: {{ $book->created_at->day }} {{ $book->created_at->englishMonth }} {{ $book->created_at->year }}</span>
                <span class="gray">ID: {{ $book->id }}</span>
            </a>
        @endforeach
    </div>
@endsection
