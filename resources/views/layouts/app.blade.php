<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bitácora')</title>
    <style>
        :root{ --bg:#f6f8fb; --card:#ffffff; --muted:#6b7280; --primary:#2563eb; --accent:#0ea5a4 }
        html,body{height:100%;margin:0;font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial}
        body{background:var(--bg);color:#111827;padding:24px}
        .container{max-width:1100px;margin:0 auto}
    header{display:flex;align-items:center;justify-content:space-between;padding:12px 0}
    .brand{font-weight:700;color:var(--primary);font-size:20px}
    .card{background:var(--card);border-radius:10px;padding:18px;box-shadow:0 6px 18px rgba(15,23,42,0.06)}
    form .row{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:12px}
        label{font-size:13px;color:var(--muted);display:block;margin-bottom:6px}
        input[type="text"], input[type="date"], input[type="number"], textarea, select{padding:10px;border:1px solid #e6e9ef;border-radius:8px;width:100%;box-sizing:border-box}
        textarea{min-height:80px}
    .grid{display:grid;grid-template-columns:2fr 1fr;gap:16px}
        table{width:100%;border-collapse:collapse}
        th,td{padding:10px;border-bottom:1px solid #eef2f7;text-align:left}
        th{background:#fbfdff;font-weight:600}
        .actions{display:flex;gap:8px}
        .btn{display:inline-block;padding:8px 12px;border-radius:8px;text-decoration:none;color:white;background:var(--primary);border:none;cursor:pointer}
        .btn.secondary{background:#6b7280}
        .muted{color:var(--muted);font-size:13px}
        footer{margin-top:18px;color:var(--muted);font-size:13px}
        @media (max-width:800px){.grid{grid-template-columns:1fr}}
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <header>
            <div class="brand">Bitácora - Departamento de Redes</div>
            <nav>
                @auth
                    <span class="muted">{{ auth()->user()->name }}</span>
                    <a href="{{ route('account.password.show') }}" class="muted" style="margin-left:8px;margin-right:8px">Mi cuenta</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button class="btn secondary" type="submit" style="margin-left:8px">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login.show') }}" class="muted" style="margin-right:8px">Iniciar sesión</a>
                    <a href="{{ route('register.show') }}" class="muted">Registrar</a>
                @endauth
            </nav>
        </header>

        @if(session('status'))
            <div class="card" style="margin-top:12px;background:#ecfeff;border-left:4px solid var(--accent)">
                <strong>{{ session('status') }}</strong>
            </div>
        @endif

        @if($errors->any())
            <div class="card" style="margin-top:12px;background:#fff1f2;border-left:4px solid #fb7185">
                <ul style="margin:0;padding-left:18px;color:#7f1d1d">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main class="card">
            @yield('content')
        </main>

        <footer class="muted">Generado por el sistema de bitácora</footer>
    </div>
</body>
</html>
