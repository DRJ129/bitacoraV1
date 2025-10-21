@extends('layouts.app')

@section('title', 'Responder preguntas')

@section('content')
    <h2>Responder preguntas de seguridad</h2>

    <form method="POST" action="{{ route('password.questions.verify', $user) }}" class="card">
        @csrf

        @foreach($questions as $q)
            <div class="row">
                <div style="flex:1">
                    <label>{{ $q->question }}</label>
                    <input name="answers[{{ $q->id }}]" required />
                </div>
            </div>
        @endforeach

        <div class="row"><button class="btn" type="submit">Verificar respuestas</button></div>
    </form>
@endsection
