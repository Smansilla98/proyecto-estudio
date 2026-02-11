<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;

class VideoRepository
{
    public function getByRitmo(int $ritmoId): Collection
    {
        return Video::where('ritmo_id', $ritmoId)
            ->with('tambor')
            ->orderBy('orden_ejecucion')
            ->get();
    }

    public function findById(int $id): ?Video
    {
        return Video::with(['ritmo', 'tambor'])->find($id);
    }

    public function create(array $data): Video
    {
        return Video::create($data);
    }

    public function update(Video $video, array $data): bool
    {
        return $video->update($data);
    }

    public function delete(Video $video): bool
    {
        return $video->delete();
    }
}

