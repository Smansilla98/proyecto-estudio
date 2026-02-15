<?php

namespace App\Http\Controllers;

use App\Models\Ritmo;
use App\Models\Tambor;
use App\Services\RitmoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RitmoController extends Controller
{
    public function __construct(
        private RitmoService $ritmoService
    ) {}

    public function index()
    {
        $ritmos = $this->ritmoService->getAllForUser(Auth::user());
        return view('ritmos.index', compact('ritmos'));
    }

    public function show(Ritmo $ritmo)
    {
        Gate::authorize('view', $ritmo);

        $ritmo->load(['creador', 'tambores', 'videos.tambor', 'partituras']);
        return view('ritmos.show', compact('ritmo'));
    }

    public function create()
    {
        Gate::authorize('create', Ritmo::class);

        $tambores = Tambor::all();
        return view('ritmos.create', compact('tambores'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Ritmo::class);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'bpm_default' => ['required', 'integer', 'min:60', 'max:200'],
            'anio' => ['nullable', 'integer', 'min:1', 'max:6'],
            'autor' => ['nullable', 'string', 'max:255'],
            'tipo' => ['nullable', 'string', 'in:Autor,Ritmo Popular,Adaptación'],
            'opcional' => ['nullable', 'boolean'],
            'anio_opcional' => ['nullable', 'string', 'max:255'],
            'tambores' => ['required', 'array', 'min:1'],
            'tambores.*' => ['exists:tambores,id'],
        ]);

        // Convertir opcional a boolean
        $validated['opcional'] = $request->has('opcional') && $request->input('opcional') == '1';

        $ritmo = $this->ritmoService->create($validated, Auth::user());

        return redirect()->route('ritmos.show', $ritmo)
            ->with('success', 'Ritmo creado exitosamente.');
    }

    public function edit(Ritmo $ritmo)
    {
        Gate::authorize('update', $ritmo);

        $tambores = Tambor::all();
        $ritmo->load('tambores');
        return view('ritmos.edit', compact('ritmo', 'tambores'));
    }

    public function update(Request $request, Ritmo $ritmo)
    {
        Gate::authorize('update', $ritmo);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'bpm_default' => ['required', 'integer', 'min:60', 'max:200'],
            'anio' => ['nullable', 'integer', 'min:1', 'max:6'],
            'autor' => ['nullable', 'string', 'max:255'],
            'tipo' => ['nullable', 'string', 'in:Autor,Ritmo Popular,Adaptación'],
            'opcional' => ['nullable', 'boolean'],
            'anio_opcional' => ['nullable', 'string', 'max:255'],
            'tambores' => ['required', 'array', 'min:1'],
            'tambores.*' => ['exists:tambores,id'],
        ]);

        // Convertir opcional a boolean
        $validated['opcional'] = $request->has('opcional') && $request->input('opcional') == '1';

        $this->ritmoService->update($ritmo, $validated, Auth::user());

        return redirect()->route('ritmos.show', $ritmo)
            ->with('success', 'Ritmo actualizado exitosamente.');
    }

    public function destroy(Ritmo $ritmo)
    {
        Gate::authorize('delete', $ritmo);

        $this->ritmoService->delete($ritmo);

        return redirect()->route('ritmos.index')
            ->with('success', 'Ritmo eliminado exitosamente.');
    }

    public function approve(Ritmo $ritmo)
    {
        Gate::authorize('approve', $ritmo);

        $this->ritmoService->approve($ritmo);

        return redirect()->back()
            ->with('success', 'Ritmo aprobado exitosamente.');
    }
}

