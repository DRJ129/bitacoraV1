<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = $request->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Contraseña actual incorrecta']);
        }

        $user->password = $data['password'];
        $user->save();

        return Redirect::route('activities.index')->with('status', 'Contraseña actualizada');
    }
}
