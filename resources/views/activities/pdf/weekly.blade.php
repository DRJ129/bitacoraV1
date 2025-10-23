<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color:#111 }
        header{display:flex;justify-content:space-between;align-items:center}
        h1{font-size:18px;margin:0}
        .meta{font-size:12px;color:#666}
        table { width: 100%; border-collapse: collapse; margin-top:12px }
        th, td { border: 1px solid #ddd; padding: 8px; font-size:12px }
        th{background:#f3f6fb;text-align:left}
    </style>
    <title>Resumen Semanal - {{ $startDate->toDateString() }} a {{ $endDate->toDateString() }}</title>
</head>
<body>
    <header>
        <div>
            <h1>Resumen Semanal</h1>
            <div class="meta">Periodo: {{ $startDate->toDateString() }} a {{ $endDate->toDateString() }}</div>
        </div>
        <div class="meta">Departamento de Redes</div>
    </header>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Duración (min)</th>
                <th>Categoría</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $a)
                <tr>
                    <td>{{ $a->date->format('Y-m-d') }}</td>
                    <td>{{ $a->title }}</td>
                    <td>{{ $a->description }}</td>
                    <td>{{ $a->duration_minutes }}</td>
                    <td>{{ $a->category }}</td>
                    <td>{{ optional($a->uploader)->name ?? optional($a->user)->name ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="meta">No hay actividades</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
