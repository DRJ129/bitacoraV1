@extends('layouts.app')

@section('title', 'Cambiar contraseña')

@section('content')
    <h2>Cambiar contraseña</h2>

    <form method="POST" action="{{ route('account.password.update') }}" class="card">
        @csrf
        <div class="row">
            <div style="width:300px">
                <label>Contraseña actual</label>
                <input name="current_password" type="password" required />
            </div>
            <div style="width:300px">
                <label>Nueva contraseña</label>
                <input name="password" type="password" required />
            </div>
            <div style="width:300px">
                <label>Confirmar nueva</label>
                <input name="password_confirmation" type="password" required />
            </div>
        </div>

        <div class="row"><button class="btn" type="submit">Actualizar contraseña</button></div>
    </form>
@endsection
