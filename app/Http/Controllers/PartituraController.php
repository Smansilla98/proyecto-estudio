<?php

namespace App\Http\Controllers;

use App\Models\Ritmo;
use App\Models\Partitura;
use App\Services\PartituraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PartituraController extends Controller
{
    public function __construct(
        private PartituraService $partituraService
    ) {}

    public function store(Request $request, Ritmo $ritmo)
    {
        Gate::authorize('create', Partitura::class);

        $validated = $request->validate([
            'archivo_pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $validated['ritmo_id'] = $ritmo->id;
        $this->partituraService->create($validated, $request->file('archivo_pdf'));

        return redirect()->back()
            ->with('success', 'Partitura agregada exitosamente.');
    }

    public function update(Request $request, Partitura $partitura)
    {
        Gate::authorize('update', $partitura);

        $validated = $request->validate([
            'archivo_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $this->partituraService->update($partitura, $validated, $request->file('archivo_pdf'));

        return redirect()->back()
            ->with('success', 'Partitura actualizada exitosamente.');
    }

    public function destroy(Partitura $partitura)
    {
        Gate::authorize('delete', $partitura);

        $this->partituraService->delete($partitura);

        return redirect()->back()
            ->with('success', 'Partitura eliminada exitosamente.');
    }
}

