@extends('layouts.app')

@section('title', 'Restablecer contraseña')

@section('content')
    <h2>Restablecer contraseña</h2>

    <form method="POST" action="{{ route('password.reset', $user) }}" class="card">
        @csrf
        <div class="row">
            <div style="width:300px">
                <label>Contraseña nueva</label>
                <input name="password" type="password" required />
            </div>
            <div style="width:300px">
                <label>Confirmar contraseña</label>
                <input name="password_confirmation" type="password" required />
            </div>
        </div>

        <div class="row"><button class="btn" type="submit">Actualizar contraseña</button></div>
    </form>
@endsection
