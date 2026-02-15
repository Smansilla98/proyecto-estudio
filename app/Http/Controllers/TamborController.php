<?php

namespace App\Http\Controllers;

use App\Models\Tambor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TamborController extends Controller
{
    public function index()
    {
        $tambores = Tambor::withCount(['ritmos', 'videos'])->latest()->get();
        return view('tambores.index', compact('tambores'));
    }

    public function create()
    {
        Gate::authorize('create', Tambor::class);
        return view('tambores.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Tambor::class);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:tambores,nombre'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $tambor = Tambor::create($validated);

        return redirect()->route('tambores.show', $tambor)
            ->with('success', 'Tambor creado exitosamente.');
    }

    public function show(Tambor $tambor)
    {
        $tambor->load(['ritmos', 'videos.ritmo']);
        return view('tambores.show', compact('tambor'));
    }

    public function edit(Tambor $tambor)
    {
        Gate::authorize('update', $tambor);
        return view('tambores.edit', compact('tambor'));
    }

    public function update(Request $request, Tambor $tambor)
    {
        Gate::authorize('update', $tambor);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:tambores,nombre,' . $tambor->id],
            'descripcion' => ['nullable', 'string'],
        ]);

        $tambor->update($validated);

        return redirect()->route('tambores.show', $tambor)
            ->with('success', 'Tambor actualizado exitosamente.');
    }

    public function destroy(Tambor $tambor)
    {
        Gate::authorize('delete', $tambor);

        // Verificar si tiene relaciones
        if ($tambor->ritmos()->count() > 0 || $tambor->videos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el tambor porque tiene ritmos o videos asociados.');
        }

        $tambor->delete();

        return redirect()->route('tambores.index')
            ->with('success', 'Tambor eliminado exitosamente.');
    }
}

