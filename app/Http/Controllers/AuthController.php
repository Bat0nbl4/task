<?php

namespace App\Http\Controllers;

use App\Enums\UserTags;
use App\Models\Book;
use App\Models\User;
use App\Models\Logs;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function showregform() {
        return view('register');
    }

    public  function register(UserRequest $request) {

        $data = $request->validated();

        $user = User::create([
            'email' => $data['email'],
            'login' => $data['login'],
            'usertag' => $data['usertag'],
            'password' => bcrypt($data['password']),
        ]);

        if($user) {
            auth('web')->login($user);
        }

        session()->put('login', $data['login']);

        return redirect(route('lk'));
    }

    public function showloginform() {
        return view('login');
    }

    public function login(Request $request) {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if ( auth('web')->attempt($data)) {
            session()->put('login', $data['login']);
            return redirect(route('lk'));
        }

        return redirect(route('login'))->withErrors(['login' => 'Неверный логин или пароль']);
    }

    public function logout() {
        auth('web')->logout();
        session()->forget('login');

        return redirect(route('login'));
    }

    public function change_user_data(Request $request) {

        $data = $request->validate([
            'email' => ['required', 'email', 'string', Rule::unique('users', 'email')->ignore($request->id)],
            'login' => ['required', 'string', Rule::unique('users', 'login')->ignore($request->id)],
        ]);

        Book::where('publisher', '=', session()->get('login'))->update(['publisher' => $data['login']]);
        Logs::where('publisher', '=', session()->get('login'))->update(['publisher' => $data['login']]);

        session()->put('login', $data['login']);

        $user = User::find($request->id);
        $user->update($data);

        return redirect(route('lk'));
    }

    public function change_user_password(Request $request) {

        $user = User::where('login', '=', session()->get('login'))->first();
        $pass = Hash::check($request->old_password, $user->password);

        if ($pass) {
            $data = $request->validate([
                'password' => ['required', 'confirmed'],
            ]);

            $user = User::find($request->id);
            $user->update($data);

            return redirect(route('lk', [ 'password' => '', 'text' => 'Пароль успешено изменён',]));
        }
        return redirect(route('lk', ['password' => 'true', 'text' => '']))->withErrors(['old_password' => 'Неверный пароль']);
    }
}
