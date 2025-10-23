@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <h2>Usuarios</h2>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role }}</td>
                        <td>
                            <a class="btn" href="{{ route('admin.users.edit', $u) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" style="display:inline" onsubmit="return confirm('Eliminar usuario?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn secondary">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:12px">{{ $users->links() }}</div>
    </div>
@endsection
