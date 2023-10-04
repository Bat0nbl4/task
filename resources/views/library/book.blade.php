@extends('layout')

<?php

use App\Models\Book;

$book = Book::where('id', $id) -> first();
/*
if ($book->image == 'none') {
    return '1';
}
*/
?>

@section('title')
    Книги
@endsection

@section('main_content')
    <div class="form book">
        <p class="gray">ID: {{ $book->id }}</p>
        <h1 class="title">{{ $book->title }}</h1>
        <h3 class="title">Автор: {{ $book->author }}</h3>
        @if($book->image != 'none')
            <img src="{{ asset('/storage/' . $book->image) }}">
        @else
            <div class="img">
                <h3>{{ $book->title }}</h3>
                <h4>{{ $book->author }}</h4>
            </div>
        @endif
        <p>Жанр: {{ $book->genre }}</p>
        <p>{{ $book->description }}</p>
            <p>Издатель: <a href="{{ route('lk') }}">{{ $book->publisher }}</a></p>
        <p>{{ $book->edition }}</p>
        <p>Дата публикации {{ $book->created_at->day }} {{ $book->created_at->englishMonth }} {{ $book->created_at->year }}</p>
        @if($book->publisher == session()->get('login') or session()->has('admin_login'))
            <div class="lk_menu">
                <a href="{{ route('admin.edit', ['id' => $id]) }}" class="button public_button">Редактировать</a>
                <a href="{{ route('admin.delete_book', ['id' => $id]) }}" class="button right-button logout">Удалить</a>
            </div>
        @endif
    </div>
@endsection
