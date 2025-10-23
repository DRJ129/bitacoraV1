<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

    $query = Activity::query()->with(['user', 'uploader'])->orderBy('date', 'desc');

        // Si no es admin, mostrar sólo actividades creadas por el usuario
        if (!$user->isAdmin()) {
            $query->where('created_by', $user->id);
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

    $activities = $query->paginate(25);

        return view('activities.index', compact('activities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $data['created_by'] = Auth::id();

        // si no es admin, forzar user_id al usuario que crea
        if (!Auth::user()->isAdmin()) {
            $data['user_id'] = Auth::id();
        }

        Activity::create($data);

        return redirect()->back()->with('status', 'Actividad registrada');
    }

    public function edit(Activity $activity)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $activity->created_by !== $user->id) {
            abort(403, 'No autorizado');
        }
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:100',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();
        if (!$user->isAdmin() && $activity->created_by !== $user->id) {
            abort(403, 'No autorizado');
        }

        $activity->update($data);

        return Redirect::route('activities.index')->with('status', 'Actividad actualizada');
    }

    public function destroy(Activity $activity)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $activity->created_by !== $user->id) {
            abort(403, 'No autorizado');
        }

        $activity->delete();
        return Redirect::route('activities.index')->with('status', 'Actividad eliminada');
    }

    public function dailyPdf(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
    $query = Activity::where('date', $date)->with(['user', 'uploader'])->orderBy('created_at');
        if (!Auth::user()->isAdmin()) {
            $query->where('created_by', Auth::id());
        }
        $activities = $query->get();

        $pdf = Pdf::loadView('activities.pdf.daily', compact('activities', 'date'));

        return $pdf->download("resumen_diario_{$date}.pdf");
    }

    public function weeklyPdf(Request $request)
    {
        $end = $request->input('end', now()->toDateString());
        $endDate = \Carbon\Carbon::parse($end);
        $startDate = $endDate->copy()->startOfWeek();

    $query = Activity::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])->with(['user', 'uploader'])->orderBy('date');
        if (!Auth::user()->isAdmin()) {
            $query->where('created_by', Auth::id());
        }
        $activities = $query->get();

        $pdf = Pdf::loadView('activities.pdf.weekly', compact('activities', 'startDate', 'endDate'));

        return $pdf->download("resumen_semanal_{$startDate->toDateString()}_a_{$endDate->toDateString()}.pdf");
    }
}
