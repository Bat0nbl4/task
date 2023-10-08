<?php

namespace App\Http\Controllers;

use App\Enums\Enums;
use App\Models\Logs;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Enum;
use App\Models\Book;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function book_register(Request $request) {
        $data = $request->validate([
            'author' => ['required'],
            'title' => ['required', 'unique:books,title'],
            'publisher' => ['required'],
            'genre' => ['required'],
            'edition' => ['required', new Enum(Enums::class)],
            'description' => ['sometimes'],
            'file' => ['sometimes', 'file', 'image'],
        ]);

        if ($request->file) {
            $path = $request->file('file')->store('uploads', 'public');
        } else {
            $path = 'none';
        }

        if ($data['description'] == null) {
            $data['description'] = 'Описание отсутсвует';
        }

        $book = Book::create([
            'author' => $data['author'],
            'title' => $data['title'],
            'publisher' => $data['publisher'],
            'genre' => $data['genre'],
            'edition' => ($data['edition']),
            'description' => ($data['description']),
            'image' => $path,
        ]);

        Logs::create([
            'book_id' => $book->id,
            'author' => $book->author,
            'title' => $book->title,
            'publisher' => $book->publisher,
            'genre' => $book->genre,
            'edition' => $book->edition,
            'description' => $book->description,
            'file' => $path,
        ]);

        return redirect(route('book', ['id' => $book->id]));
    }
    /*
    function books($request) {
        $this->check();

        if ($request->sort_by) {
            session()->put('reverse_books', $request->reverse_books);
            session()->put('books_sort_type', $request->sort_by);
        }
        $search = [$request->search_by, $request->search];

        if (session()->get('reverse_books') == true) {
            $books = Book::orderByDesc(session()->get('books_sort_type'))->paginate(10);
        } else {
            $books = Book::orderBy(session()->get('books_sort_type'))->paginate(10);
        }

        if ($request->search) {
            $books = Book::where($search[0], '=', $search[1])->paginate(10);
        }

        Paginator::useBootstrap();
        return [$books, $search];
    }*/

    public function lk(Request $request, bool $password = null, string $text = null) {

        $this->check();
        if ($request->sort_by) {
            session()->put('reverse_books', $request->reverse_users);
            session()->put('books_sort_type', $request->sort_by);
        }

        $this->change_search($request);

        if ($request->search != '') {
            if (session()->get('reverse_books') == true) {
                $books = Book::where('publisher', '=', session()->get('login'))->where(session()->get('search_by'), '=', session()->get('search'))->orderByDesc(session()->get('books_sort_type'))->paginate(10);
            } else {
                $books = Book::where('publisher', '=', session()->get('login'))->where(session()->get('search_by'), '=', session()->get('search'))->orderBy(session()->get('books_sort_type'))->paginate(10);
            }
        } else {
            if (session()->get('reverse_books') == true) {
                $books = Book::where('publisher', '=', session()->get('login'))->orderByDesc(session()->get('books_sort_type'))->paginate(10);
            } else {
                $books = Book::where('publisher', '=', session()->get('login'))->orderBy(session()->get('books_sort_type'))->paginate(10);
            }
        }

        Paginator::useBootstrap();
        return view('lk', compact('books', 'request', 'password', 'text'));
    }

    public function show_user(Request $request) {

        $user = User::where('login', '=', $request->user)->first();

        $this->check();
        if ($request->sort_by) {
            session()->put('reverse_books', $request->reverse_users);
            session()->put('books_sort_type', $request->sort_by);
        }

        $this->change_search($request);

        if ($request->search != '') {
            if (session()->get('reverse_books') == true) {
                $books = Book::where('publisher', '=', $user->login)->where(session()->get('search_by'), '=', session()->get('search'))->orderByDesc(session()->get('books_sort_type'))->paginate(10);
            } else {
                $books = Book::where('publisher', '=', $user->login)->where(session()->get('search_by'), '=', session()->get('search'))->orderBy(session()->get('books_sort_type'))->paginate(10);
            }
        } else {
            if (session()->get('reverse_books') == true) {
                $books = Book::where('publisher', '=', $user->login)->orderByDesc(session()->get('books_sort_type'))->paginate(10);
            } else {
                $books = Book::where('publisher', '=', $user->login)->orderBy(session()->get('books_sort_type'))->paginate(10);
            }
        }

        Paginator::useBootstrap();
        return view('user', compact('user', 'books'));
    }

    public function library(Request $request) {

        $this->check();
        if ($request->sort_by) {
            session()->put('reverse_books', $request->reverse_books);
            session()->put('books_sort_type', $request->sort_by);
        }
        $this->change_search($request);

        if ($request->search != '') {
            if (session()->get('reverse_books') == true) {
                $books = Book::where(session()->get('search_by'), '=', session()->get('search'))->orderByDesc(session()->get('books_sort_type'))->paginate(10);
            } else {
                $books = Book::where(session()->get('search_by'), '=', session()->get('search'))->orderBy(session()->get('books_sort_type'))->paginate(10);
            }
        } else {
            if (session()->get('reverse_books') == true) {
                $books = Book::orderByDesc(session()->get('books_sort_type'))->paginate(10);
            } else {
                $books = Book::orderBy(session()->get('books_sort_type'))->paginate(10);
            }
        }



        $genres = Book::distinct()->orderBy('genre')->get(['genre']);

        Paginator::useBootstrap();
        return view('library/library', compact('books', 'request', 'genres'));
    }

    // ---------------------- PRIVATE
    private function check() {
        if (!session()->has('books_sort_type') or session()->get('books_sort_type') == '') {
            session()->put('books_sort_type', 'id');
            session()->put('reverse_books', '');
        }
        if (!session()->has('users_sort_type') or session()->get('users_sort_type') == '') {
            session()->put('users_sort_type', 'id');
            session()->put('reverse_users', '');
        }
        if (!session()->has('logs_sort_type') or session()->get('logs_sort_type') == '') {
            session()->put('logs_sort_type', 'id');
            session()->put('reverse_logs', '');
        }
        if (!session()->has('search_by')) {
            session()->put('search_by', 'id');
            session()->put('search', '');
        }
    }

    private function change_search($request) {
        if ($request->search_by) {
            session()->put('search_by', $request->search_by);
            session()->put('search', $request->search);
        }
    }
    // ----------------------- END PRIVATE

    public function show_books() {
        $this->check();

        $books = Book::all()->sortByDesc('created_at')->take(5);
        return view('home', compact('books'));
    }

    public function show_book($id) {
        //$book = Book::where('id', $id) -> first();
        return view('library/book', ['id' => $id]);
        /*
        if ($book) {
            ;
        } else {
            return redirect(route('home'));
        }*/

    }
}
