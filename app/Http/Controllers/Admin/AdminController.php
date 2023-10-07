<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Logs;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use function Laravel\Prompts\search;

class AdminController extends Controller
{
    public function index() {
        return view('admin.admin_login');
    }

    public function login(Request $request) {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if ( auth('admin')->attempt($data)) {
            session()->put('admin_login', $data['login']);
            return redirect(route('admin.panel_books'));
        }

        return redirect(route('admin.login'))->withErrors(['login' => 'Неверный логин или пароль']);
    }

    public function logout() {
        auth('admin')->logout();
        session()->forget('admin_login');

        return redirect(route('admin.login'));
    }

    private function change_search($request) {
        if ($request->search_by) {
            session()->put('search_by', $request->search_by);
            session()->put('search', $request->search);
        }
    }

    public function show_panel_books(Request $request) {

        $this->change_search($request);
        if ($request->sort_by) {
            session()->put('reverse_books', $request->reverse_books);
            session()->put('books_sort_type', $request->sort_by);
        }

        if ($request->search != '') {
            if (session()->get('reverse_books') == true) {
                $books = Book::where(session()->get('search_by'), '=', session()->get('search'))->orderByDesc(session()->get('books_sort_type'))->paginate(25);
            } else {
                $books = Book::where(session()->get('search_by'), '=', session()->get('search'))->orderBy(session()->get('books_sort_type'))->paginate(25);
            }
        } else {
            if (session()->get('reverse_books') == true) {
                $books = Book::orderByDesc(session()->get('books_sort_type'))->paginate(25);
            } else {
                $books = Book::orderBy(session()->get('books_sort_type'))->paginate(25);
            }
        }

        Paginator::useBootstrap();
        return view('admin.admin_panel_books', compact('books', 'request'));
    }

    public function show_panel_logs(Request $request) {

        $this->change_search($request);
        if ($request->sort_by) {
            session()->put('reverse_logs', $request->reverse_logs);
            session()->put('logs_sort_type', $request->sort_by);
        }

        if ($request->search != '') {
            if (session()->get('reverse_logs') == true) {
                $logs = Logs::where(session()->get('search_by'), '=', session()->get('search'))->orderByDesc(session()->get('logs_sort_type'))->paginate(25);
            } else {
                $logs = Logs::where(session()->get('search_by'), '=', session()->get('search'))->orderBy(session()->get('logs_sort_type'))->paginate(25);
            }
        } else {
            if (session()->get('reverse_logs') == true) {
                $logs = Logs::orderByDesc(session()->get('logs_sort_type'))->paginate(25);
            } else {
                $logs = Logs::orderBy(session()->get('logs_sort_type'))->paginate(25);
            }
        }

        Paginator::useBootstrap();
        return view('admin.admin_panel_logs', compact('logs', 'request'));
    }

    public function show_panel_users(Request $request) {

        $this->change_search($request);
        if ($request->sort_by) {
            session()->put('reverse_users', $request->reverse_users);
            session()->put('users_sort_type', $request->sort_by);
        }

        if ($request->search != '') {
            if (session()->get('reverse_users') == true) {
                $users = User::where(session()->get('search_by'), '=', session()->get('search'))->orderByDesc(session()->get('users_sort_type'))->paginate(25);
            } else {
                $users = User::where(session()->get('search_by'), '=', session()->get('search'))->orderBy(session()->get('users_sort_type'))->paginate(25);
            }
        } else {
            if (session()->get('reverse_users') == true) {
                $users = User::orderByDesc(session()->get('users_sort_type'))->paginate(25);
            } else {
                $users = User::orderBy(session()->get('users_sort_type'))->paginate(25);
            }
        }

        Paginator::useBootstrap();
        return view('admin.admin_panel_users', compact('users', 'request'));
    }

    public function edit(Request $request) {
        $book = Book::findOrFail($request->id);

        return view('library/book_form')->with('book', $book);
    }

    public function edit_user(Request $request) {
        $user = User::findOrFail($request->id);

        return view('register')->with('user', $user);
    }

    public function update(BookRequest $request) {

        $data = $request->validated();
        if ($request->file) {
            $path = $request->file('file')->store('uploads', 'public');
        } else {
            $path = 'none';
        }

        $book = Book::find($request->id);
        $book->update($data);

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

        if ($path and $path != $book->image) {
            Storage::delete($book->image);
            $book->image = $request->file('file')->store('uploads', 'public');
            $book->save();
        }

        return redirect(route('book', ['id' => $book->id]));
    }

    public function delete_book($id) {
        Book::destroy($id);

        if (session()->has('admin_login')) {
            return redirect(route('admin.panel'));
        } else {
            return redirect(route('home'));
        }
    }

    public function user_update(Request $request) {

        $data = $request->validate([
            'email' => ['required', 'email', 'string', Rule::unique('users', 'email')->ignore($this->id)],
            'login' => ['required', 'string', Rule::unique('users', 'login')->ignore($this->id)],
        ]);

        $user = User::find($request->id);

        $user->update($data);
        $user->save();

        return redirect(route('home'));
    }

    public function delete_user($id) {
        User::destroy($id);

        if (session()->has('admin_login')) {
            return redirect(route('admin.panel_users'));
        } else {
            return redirect(route('home'));
        }

    }
}
