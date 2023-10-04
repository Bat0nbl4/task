@extends('layout')

@section('title')Бланк@endsection

@section('main_content')
    <h1>Чёто</h1>
    <form method="post" action="/blank/check">
        @csrf
        <input type="email" name="email" id="email" placeholder="Автор"><br>
        <input type="text" name="subject" id="text" placeholder="Книга"><br>
        <button type="submit">Отправить</button>
    </form>
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error  }}</li><br>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
