@extends('layout')

@section('title')
    {{ isset($book) ? 'Редактировать книгу' : 'Регистрация книги' }}
@endsection

@section('main_content')
    <form method="post" action="{{ isset($book) ? route('admin.update') : route('regbook') }}" class="form" enctype="multipart/form-data">
        @csrf
        @if(isset($book))
            @method('PUT')
            <input hidden type="text" name="id" id="id" value="{{ $book->id }}">
        @endif

        <input hidden type="text" name="publisher" id="publisher" value="{{ isset($book) ? $book->publisher : session()->get('login') }}">
        <h2>{{ isset($book) ? 'Редактировать книгу' : 'Регистрация книги' }}</h2>
        <div class="entry">
            <input value="{{ isset($book) ? $book->title : '' }}" type="text" name="title" id="title" placeholder="Название книги">
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="entry">
            <input value="{{ isset($book) ? $book->title : '' }}" type="text" name="author" id="author" placeholder="Автор">
            @error('title')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="entry">
            <input value="{{ isset($book) ? $book->genre : ''}}" type="text" name="genre" id="genre" placeholder="Жанр">
            @error('genre')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="entry">
            <select type="edition" name="edition" id="edition">
                @foreach(\App\Enums\Enums::cases() as $key => $label)
                    <option value="{{ $label->value }}">{{ $label->value }}</option>
                @endforeach
            </select>
            @error('edition')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="entry">
            <textarea name="description" id="description" placeholder="Описание">{{ isset($book) ? $book->description : ''}}</textarea>
            @error('description')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="entry">
            @if(isset($book))
                @if($book->image != 'none')
                    <img src="{{ asset('/storage/' . $book->image) }}">
                @else
                    <p align="center" class="danger">Обложка отсутствует</p>
                @endif
            @endif
            <label class="input-file">
                <script>
                    function getFileName() {
                        var file = document.getElementById('file').files[0].name;
                        if (file == "") {
                            document.getElementById('file-name').innerHTML = 'Выберете обложку';
                        } else {
                            document.getElementById('file-name').innerHTML = file;
                        }
                        //document.getElementById('file-img').src = file; не работает(
                    }
                </script>
                <input type="file" name="file" id="file" onchange="getFileName()" hidden="">
                <span id="file-name" class="button logout full_w">Выберете обложку</span>
            </label>
            @error('file')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="button full_w">Подтвердить</button>
    </form>
@endsection
