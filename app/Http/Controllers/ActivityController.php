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
        $query = Activity::query()->orderBy('date', 'desc');

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

        Activity::create($data);

        return redirect()->back()->with('status', 'Actividad registrada');
    }

    public function edit(Activity $activity)
    {
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

        $activity->update($data);

        return Redirect::route('activities.index')->with('status', 'Actividad actualizada');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return Redirect::route('activities.index')->with('status', 'Actividad eliminada');
    }

    public function dailyPdf(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $activities = Activity::where('date', $date)->orderBy('created_at')->get();

        $pdf = Pdf::loadView('activities.pdf.daily', compact('activities', 'date'));

        return $pdf->download("resumen_diario_{$date}.pdf");
    }

    public function weeklyPdf(Request $request)
    {
        $end = $request->input('end', now()->toDateString());
        $endDate = \Carbon\Carbon::parse($end);
        $startDate = $endDate->copy()->startOfWeek();

        $activities = Activity::whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('date')
            ->get();

        $pdf = Pdf::loadView('activities.pdf.weekly', compact('activities', 'startDate', 'endDate'));

        return $pdf->download("resumen_semanal_{$startDate->toDateString()}_a_{$endDate->toDateString()}.pdf");
    }
}
