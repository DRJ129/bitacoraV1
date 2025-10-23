<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'questions' => 'required|array|size:3',
            'questions.*.question' => 'required|string|max:255',
            'questions.*.answer' => 'required|string|max:255',
            'role' => 'nullable|in:user,admin',
        ]);

        $role = $data['role'] ?? 'user';

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $role,
        ]);

        foreach ($data['questions'] as $q) {
            SecurityQuestion::create([
                'user_id' => $user->id,
                'question' => $q['question'],
                'answer_hash' => Hash::make($q['answer']),
            ]);
        }

        Auth::login($user);

        return Redirect::route('activities.index');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Redirect::intended(route('activities.index'));
        }

        return back()->withErrors(['email' => 'Credenciales inválidas']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::route('activities.index');
    }
}
