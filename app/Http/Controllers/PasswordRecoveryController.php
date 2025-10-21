<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PasswordRecoveryController extends Controller
{
    public function requestEmail()
    {
        return view('auth.passwords.email');
    }

    public function postEmail(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);

        $user = User::where('email', $data['email'])->first();
        if (!$user) return back()->withErrors(['email' => 'Email no registrado']);

        // Llevar al usuario a responder preguntas
        return Redirect::route('password.questions', ['user' => $user->id]);
    }

    public function showQuestions(User $user)
    {
        $questions = $user->securityQuestions()->get(['id', 'question']);
        return view('auth.passwords.questions', compact('user', 'questions'));
    }

    public function verifyQuestions(Request $request, User $user)
    {
        $data = $request->validate(['answers' => 'required|array']);

        $answers = $data['answers'];
        $questions = $user->securityQuestions()->get();

        foreach ($questions as $q) {
            if (!isset($answers[$q->id])) return back()->withErrors(['answers' => 'Respuestas incompletas']);
            if (!Hash::check($answers[$q->id], $q->answer_hash)) {
                return back()->withErrors(['answers' => 'Respuestas incorrectas']);
            }
        }

        // Si todo está bien, permitir reset
        return Redirect::route('password.reset.form', ['user' => $user->id]);
    }

    public function showResetForm(User $user)
    {
        return view('auth.passwords.reset', compact('user'));
    }

    public function resetPassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user->password = $data['password'];
        $user->save();

        return Redirect::route('login.show')->with('status', 'Contraseña actualizada, inicia sesión.');
    }
}
