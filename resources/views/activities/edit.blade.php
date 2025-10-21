@extends('layouts.app')

@section('title', 'Editar actividad')

@section('content')
    <h2>Editar actividad</h2>

    <form method="POST" action="{{ route('activities.update', $activity) }}" class="card">
        @csrf
        @method('PUT')

        <div class="row">
            <div style="flex:1">
                <label>Título</label>
                <input name="title" value="{{ old('title', $activity->title) }}" required />
            </div>
            <div style="width:180px">
                <label>Fecha</label>
                <input type="date" name="date" value="{{ old('date', $activity->date->format('Y-m-d')) }}" required />
            </div>
        </div>

        <div class="row">
            <div style="flex:1">
                <label>Descripción</label>
                <textarea name="description">{{ old('description', $activity->description) }}</textarea>
            </div>
        </div>

        <div class="row">
            <div style="width:160px">
                <label>Duración (min)</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $activity->duration_minutes) }}" />
            </div>
            <div style="width:160px">
                <label>Categoría</label>
                <input name="category" value="{{ old('category', $activity->category) }}" />
            </div>
        </div>

        <div class="row">
            <button class="btn" type="submit">Guardar</button>
            <a href="{{ route('activities.index') }}" class="btn secondary">Cancelar</a>
        </div>
    </form>
@endsection
