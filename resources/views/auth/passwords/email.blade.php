@extends('layouts.app')

@section('title', 'Recuperar contraseña')

@section('content')
    <h2>Recuperar contraseña</h2>

    <form method="POST" action="{{ route('password.email.post') }}" class="card">
        @csrf
        <div class="row">
            <div style="flex:1">
                <label>Email</label>
                <input name="email" type="email" required />
            </div>
        </div>

        <div class="row"><button class="btn" type="submit">Continuar</button></div>
    </form>
@endsection
