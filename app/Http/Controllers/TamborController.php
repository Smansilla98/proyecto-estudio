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

    public function show(Tambor $tambore)
    {
        $tambore->load(['ritmos', 'videos.ritmo']);
        return view('tambores.show', compact('tambore'));
    }

    public function edit(Tambor $tambore)
    {
        Gate::authorize('update', $tambore);
        return view('tambores.edit', compact('tambore'));
    }

    public function update(Request $request, Tambor $tambore)
    {
        Gate::authorize('update', $tambore);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:tambores,nombre,' . $tambore->id],
            'descripcion' => ['nullable', 'string'],
        ]);

        $tambore->update($validated);

        return redirect()->route('tambores.show', $tambore)
            ->with('success', 'Tambor actualizado exitosamente.');
    }

    public function destroy(Tambor $tambore)
    {
        Gate::authorize('delete', $tambore);

        // Verificar si tiene relaciones
        if ($tambore->ritmos()->count() > 0 || $tambore->videos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el tambor porque tiene ritmos o videos asociados.');
        }

        $tambore->delete();

        return redirect()->route('tambores.index')
            ->with('success', 'Tambor eliminado exitosamente.');
    }
}

