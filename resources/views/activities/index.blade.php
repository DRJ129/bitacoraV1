@extends('layouts.app')

@section('title', 'Actividades')

@section('content')
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
        <div style="display:flex;gap:8px">
            <a class="btn" href="{{ route('activities.index') }}">Actividades</a>
            @if(auth()->user() && auth()->user()->isAdmin())
                <a class="btn secondary" href="{{ route('admin.users.index') }}">Usuarios</a>
            @endif
        </div>
        <div>
            <a class="btn" href="#activities-list">Ir al listado</a>
        </div>
    </div>

    <div class="grid" id="activities-list">
        <div>
            <h2>Listado</h2>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Categoría</th>
                            @if(auth()->user() && auth()->user()->isAdmin())
                                <th>Usuario</th>
                            @endif
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $act)
                            <tr>
                                <td>{{ $act->date->format('Y-m-d') }}</td>
                                <td>{{ $act->title }}</td>
                                <td>{{ $act->description }}</td>
                                <td>{{ $act->duration_minutes }}</td>
                                <td>{{ $act->category }}</td>
                                @if(auth()->user() && auth()->user()->isAdmin())
                                    <td>{{ optional($act->uploader)->name ?? optional($act->user)->name ?? '—' }}</td>
                                @endif
                                <td style="width:160px">
                                    <div class="actions">
                                        <a class="btn" href="{{ route('activities.edit', $act) }}">Editar</a>
                                        <form method="POST" action="{{ route('activities.destroy', $act) }}" onsubmit="return confirm('Eliminar actividad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn secondary" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @if(auth()->user() && auth()->user()->isAdmin())
                                <tr><td colspan="7" class="muted">No hay actividades</td></tr>
                            @else
                                <tr><td colspan="6" class="muted">No hay actividades</td></tr>
                            @endif
                        @endforelse
                    </tbody>
                </table>

                <div style="margin-top:12px" class="actions">
                    <form method="GET" action="{{ route('activities.dailyPdf') }}">
                        <label>Fecha</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" />
                        <div style="margin-top:6px"><button class="btn" type="submit">PDF Diario</button></div>
                    </form>

                    <form method="GET" action="{{ route('activities.weeklyPdf') }}">
                        <label>Fin de semana (fecha)</label>
                        <input type="date" name="end" value="{{ date('Y-m-d') }}" />
                        <div style="margin-top:6px"><button class="btn secondary" type="submit">PDF Semanal</button></div>
                    </form>
                </div>

                <div style="margin-top:8px">{{ $activities->links() }}</div>
            </div>
        </div>

        <div>
            <h2>Registrar actividad</h2>
            <form method="POST" action="{{ route('activities.store') }}" class="card">
                @csrf
                <div class="row">
                    <div style="flex:1">
                        <label>Título</label>
                        <input name="title" required />
                    </div>
                    <div style="width:180px">
                        <label>Fecha</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required />
                    </div>
                </div>

                <div class="row">
                    <div style="flex:1">
                        <label>Descripción</label>
                        <textarea name="description"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div style="width:160px">
                        <label>Duración (min)</label>
                        <input type="number" name="duration_minutes" />
                    </div>
                    <div style="width:160px">
                        <label>Categoría</label>
                        <input name="category" />
                    </div>
                </div>

                <div class="row">
                    <button class="btn" type="submit">Agregar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
