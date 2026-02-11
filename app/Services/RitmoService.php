<?php

namespace App\Services;

use App\Models\Ritmo;
use App\Models\User;
use App\Repositories\RitmoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RitmoService
{
    public function __construct(
        private RitmoRepository $ritmoRepository
    ) {}

    public function getAllForUser(User $user): array
    {
        if ($user->hasRole('admin')) {
            $ritmos = $this->ritmoRepository->getAll();
        } elseif ($user->hasRole('profesor')) {
            $ritmos = Ritmo::where('created_by', $user->id)
                ->with(['creador', 'tambores', 'videos', 'partituras'])
                ->get();
        } else {
            $ritmos = $this->ritmoRepository->getAprobados();
        }

        return $ritmos->toArray();
    }

    public function create(array $data, User $user): Ritmo
    {
        return DB::transaction(function () use ($data, $user) {
            $data['created_by'] = $user->id;
            $data['approved'] = $user->hasRole('admin'); // Auto-aprobar si es admin

            $ritmo = $this->ritmoRepository->create($data);

            if (isset($data['tambores'])) {
                $this->ritmoRepository->syncTambores($ritmo, $data['tambores']);
            }

            return $ritmo->load(['creador', 'tambores', 'videos', 'partituras']);
        });
    }

    public function update(Ritmo $ritmo, array $data, User $user): Ritmo
    {
        return DB::transaction(function () use ($ritmo, $data, $user) {
            $this->ritmoRepository->update($ritmo, $data);

            if (isset($data['tambores'])) {
                $this->ritmoRepository->syncTambores($ritmo, $data['tambores']);
            }

            return $ritmo->fresh(['creador', 'tambores', 'videos', 'partituras']);
        });
    }

    public function delete(Ritmo $ritmo): bool
    {
        return DB::transaction(function () use ($ritmo) {
            // Eliminar videos y partituras asociadas
            $disk = config('filesystems.default', 'local');
            foreach ($ritmo->videos as $video) {
                if ($video->url_video && !filter_var($video->url_video, FILTER_VALIDATE_URL)) {
                    if (Storage::disk($disk)->exists($video->url_video)) {
                        Storage::disk($disk)->delete($video->url_video);
                    }
                }
            }

            foreach ($ritmo->partituras as $partitura) {
                if ($partitura->archivo_pdf && !filter_var($partitura->archivo_pdf, FILTER_VALIDATE_URL)) {
                    if (Storage::disk($disk)->exists($partitura->archivo_pdf)) {
                        Storage::disk($disk)->delete($partitura->archivo_pdf);
                    }
                }
            }

            return $this->ritmoRepository->delete($ritmo);
        });
    }

    public function approve(Ritmo $ritmo): Ritmo
    {
        $this->ritmoRepository->approve($ritmo);
        return $ritmo->fresh(['creador', 'tambores', 'videos', 'partituras']);
    }
}

