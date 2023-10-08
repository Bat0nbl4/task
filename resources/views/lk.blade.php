@extends('layout')

@section('title')
    Личный кабинет
@endsection

@section('main_content')
    <?php
        use App\Models\User;
        $user = User::where('login', session()->get('login')) -> first();
    ?>
    @if(isset($request))
        <h1>{{ $request->sort_by }}</h1>
    @endif
    @if(isset($password))
        <form method="post" class="form" action="{{ route('change_user_password') }}">
            @csrf
            @method('PUT')
            <input hidden name="id" value="{{ $user->id }}">
            <h2>Смена пароля</h2>
            <div class="entry">
                <input name="old_password" type="password" placeholder="Старый пароль">
                @error('old_password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="password">
                <input name="password" type="password" placeholder="Новый пароль">
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="entry">
                <input name="password_confirmation" type="password" placeholder="Повтор пароля">
                @error('password_confirmation')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="entry">
                <button class="button full_w" type="submit">Сменить</button>
            </div>
            <a href="{{ route('lk') }}">Я передумал</a>
        </form>
    @else
        <form method="post" class="form" action="{{ route('change_user_data') }}">
            @csrf
            @method('PUT')
            <h2>Данные пользователя</h2>
            <input hidden name="id" value="{{ $user->id }}">
            <span>Ваш ID: {{ $user->id }}</span>
            <span>Статус: {{ $user->usertag }}</span>
            <div class="entry">
                <span>Имя пользователя: </span>
                <input name="login" value="{{ $user->login }}">
                @error('login')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="entry">
                <span>Почта: </span>
                <input name="email" value="{{ $user->email }}">
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="entry">
                <button class="button full_w" type="submit">Изменить данные</button>
            </div>
            <div class="entry">
                <a href="{{ route('lk', ['password' => 'true']) }}" class="button full_w logout">Сменить пароль</a>
            </div>
            <div class="entry">
                <a href="{{ route('logout') }}" class="button full_w logout">Выйти</a>
            </div>
            <span><a href="{{ route('show_user', ['user' => $user->login]) }}">Посмотреть свой профиль как пользователь</a></span>
            @guest('admin')
                <span><a href="{{ route('admin.login') }}">Войти как администратор</a></span>
            @endguest

        </form>
    @endif
    @if($user->usertag == 'Издатель')
        <div class="form">
            <h1 class="title">Ваши книги</h1>
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
            <div class="lk_menu">
                <a href="{{ route('book_form') }}" class="button public_button">Создать книгу</a>
            </div>
        </div>
    @endif
@endsection
