@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    <h2>Registrar usuario</h2>

    <form method="POST" action="{{ route('register') }}" class="card">
        @csrf
        <div class="row">
            <div style="flex:1">
                <label>Nombre</label>
                <input name="name" value="{{ old('name') }}" required />
            </div>
            <div style="width:220px">
                <label>Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required />
            </div>
        </div>

        <div class="row">
            <div style="width:300px">
                <label>Password</label>
                <input name="password" type="password" required />
            </div>
            <div style="width:300px">
                <label>Confirmar password</label>
                <input name="password_confirmation" type="password" required />
            </div>
        </div>

        <h3>Preguntas de seguridad (elige y responde 3)</h3>
        @for($i=0;$i<3;$i++)
            <div class="row">
                <div style="flex:1">
                    <label>Pregunta #{{ $i+1 }}</label>
                    <input name="questions[{{ $i }}][question]" value="{{ old('questions.' . $i . '.question') }}" required />
                </div>
                <div style="width:300px">
                    <label>Respuesta</label>
                    <input name="questions[{{ $i }}][answer]" value="{{ old('questions.' . $i . '.answer') }}" required />
                </div>
            </div>
        @endfor

        <div class="row">
            <button class="btn" type="submit">Registrar</button>
        </div>
    </form>
@endsection
