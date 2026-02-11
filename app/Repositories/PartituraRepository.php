<?php

namespace App\Repositories;

use App\Models\Partitura;
use Illuminate\Database\Eloquent\Collection;

class PartituraRepository
{
    public function getByRitmo(int $ritmoId): Collection
    {
        return Partitura::where('ritmo_id', $ritmoId)
            ->with('ritmo')
            ->get();
    }

    public function findById(int $id): ?Partitura
    {
        return Partitura::with('ritmo')->find($id);
    }

    public function create(array $data): Partitura
    {
        return Partitura::create($data);
    }

    public function update(Partitura $partitura, array $data): bool
    {
        return $partitura->update($data);
    }

    public function delete(Partitura $partitura): bool
    {
        return $partitura->delete();
    }
}

