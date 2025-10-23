@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    @push('styles')
    <style>
        .login-outer{display:flex;align-items:center;justify-content:center;min-height:60vh}
        .login-card{width:100%;max-width:420px;padding:28px;border-radius:12px;box-shadow:0 10px 30px rgba(2,6,23,0.12);background:#fff}
        .login-card h2{margin:0 0 12px 0;font-size:20px}
        .login-field{display:flex;flex-direction:column;margin-bottom:12px}
        .login-field label{font-size:13px;color:var(--muted);margin-bottom:6px}
        .login-field input{padding:10px;border:1px solid #e6e9ef;border-radius:8px;font-size:14px}
        .login-actions{display:flex;align-items:center;justify-content:space-between;margin-top:8px}
        .login-small{font-size:13px;color:var(--muted);text-decoration:none}
    </style>
    @endpush

    <div class="login-outer">
        <div class="login-card">
            <h2>Iniciar sesión</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required />
                </div>

                <div class="login-field">
                    <label for="password">Contraseña</label>
                    <input id="password" name="password" type="password" required />
                </div>

                <div class="login-actions">
                    <a href="{{ route('password.email') }}" class="login-small">¿Olvidaste tu contraseña?</a>
                    <button class="btn" type="submit">Entrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
