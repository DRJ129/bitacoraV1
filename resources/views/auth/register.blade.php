@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    @push('styles')
    <style>
        .login-outer{display:flex;align-items:center;justify-content:center;min-height:60vh}
        .login-card{width:100%;max-width:620px;padding:28px;border-radius:12px;box-shadow:0 10px 30px rgba(2,6,23,0.08);background:#fff}
        .login-card h2{margin:0 0 12px 0;font-size:20px}
        .login-field{display:flex;flex-direction:column;margin-bottom:12px}
        .login-field label{font-size:13px;color:var(--muted);margin-bottom:6px}
        .login-field input, .login-field select, .login-field textarea{padding:10px;border:1px solid #e6e9ef;border-radius:8px;font-size:14px}
        .login-actions{display:flex;align-items:center;justify-content:flex-end;margin-top:8px;gap:8px}
        .login-small{font-size:13px;color:var(--muted);text-decoration:none}
        .questions-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        @media (max-width:800px){.questions-grid{grid-template-columns:1fr}}
    </style>
    @endpush

    <div class="login-outer">
        <div class="login-card">
            <h2>Registrar usuario</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="login-field">
                    <label for="name">Nombre</label>
                    <input id="name" name="name" value="{{ old('name') }}" required />
                </div>

                <div class="login-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required />
                </div>

                <div class="login-field">
                    <label for="password">Contraseña</label>
                    <input id="password" name="password" type="password" required />
                </div>

                <div class="login-field">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required />
                </div>

                <div class="login-field" style="width:240px">
                    <label for="role">Rol</label>
                    <select id="role" name="role">
                        <option value="user" {{ old('role')=='user' ? 'selected' : '' }}>Usuario</option>
                        <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <h3 style="margin-top:12px">Preguntas de seguridad (elige y responde 3)</h3>
                <div class="questions-grid">
                @for($i=0;$i<3;$i++)
                    <div>
                        <div class="login-field">
                            <label>Pregunta #{{ $i+1 }}</label>
                            <input name="questions[{{ $i }}][question]" value="{{ old('questions.' . $i . '.question') }}" required />
                        </div>
                    </div>
                    <div>
                        <div class="login-field">
                            <label>Respuesta</label>
                            <input name="questions[{{ $i }}][answer]" value="{{ old('questions.' . $i . '.answer') }}" required />
                        </div>
                    </div>
                @endfor
                </div>

                <div class="login-actions">
                    <a href="{{ route('login.show') }}" class="login-small">¿Ya tienes cuenta? Inicia sesión</a>
                    <button class="btn" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
