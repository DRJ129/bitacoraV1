@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <h2>Editar usuario</h2>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="card">
        @csrf
        @method('PUT')

        <div class="row">
            <div style="flex:1">
                <label>Nombre</label>
                <input name="name" value="{{ old('name', $user->name) }}" required />
            </div>
            <div style="width:300px">
                <label>Email</label>
                <input name="email" value="{{ old('email', $user->email) }}" required />
            </div>
            <div style="width:160px">
                <label>Rol</label>
                <select name="role">
                    <option value="user" {{ $user->role==='user' ? 'selected' : '' }}>Usuario</option>
                    <option value="admin" {{ $user->role==='admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
        </div>

        <div class="row"><button class="btn" type="submit">Guardar</button></div>
    </form>
@endsection
