<?php

namespace App\Repositories;

use App\Models\Ritmo;
use Illuminate\Database\Eloquent\Collection;

class RitmoRepository
{
    public function getAll(): Collection
    {
        return Ritmo::with(['creador', 'tambores', 'videos', 'partituras'])->get();
    }

    public function getAprobados(): Collection
    {
        return Ritmo::aprobados()
            ->with(['creador', 'tambores', 'videos', 'partituras'])
            ->get();
    }

    public function getPendientes(): Collection
    {
        return Ritmo::pendientes()
            ->with(['creador', 'tambores', 'videos', 'partituras'])
            ->get();
    }

    public function findById(int $id): ?Ritmo
    {
        return Ritmo::with(['creador', 'tambores', 'videos.tambor', 'partituras'])->find($id);
    }

    public function create(array $data): Ritmo
    {
        return Ritmo::create($data);
    }

    public function update(Ritmo $ritmo, array $data): bool
    {
        return $ritmo->update($data);
    }

    public function delete(Ritmo $ritmo): bool
    {
        return $ritmo->delete();
    }

    public function syncTambores(Ritmo $ritmo, array $tamborIds): void
    {
        $ritmo->tambores()->sync($tamborIds);
    }

    public function approve(Ritmo $ritmo): bool
    {
        return $ritmo->update(['approved' => true]);
    }
}

