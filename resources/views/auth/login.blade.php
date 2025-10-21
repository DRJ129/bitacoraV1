@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <h2>Iniciar sesión</h2>

    <form method="POST" action="{{ route('login') }}" class="card">
        @csrf
        <div class="row">
            <div style="flex:1">
                <label>Email</label>
                <input name="email" type="email" required />
            </div>
            <div style="width:300px">
                <label>Password</label>
                <input name="password" type="password" required />
            </div>
        </div>

        <div class="row">
            <button class="btn" type="submit">Entrar</button>
        </div>
        <div class="row" style="margin-top:8px">
            <a href="{{ route('password.email') }}" class="muted">¿Olvidaste tu contraseña?</a>
        </div>
    </form>
@endsection
