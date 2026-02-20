<?php

namespace App\Services;

use App\Models\Partitura;
use App\Repositories\PartituraRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PartituraService
{
    public function __construct(
        private PartituraRepository $partituraRepository
    ) {}

    public function create(array $data, ?UploadedFile $file = null): Partitura
    {
        if ($file) {
            $disk = 'public';
            // Guardar con el nombre original y extensión
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('partituras', $filename, $disk);
            $data['archivo_pdf'] = $path;
        }

        return $this->partituraRepository->create($data);
    }

    public function update(Partitura $partitura, array $data, ?UploadedFile $file = null): Partitura
    {
        if ($file) {
            $disk = 'public';
            
            // Eliminar PDF anterior si existe y no es URL externa
            if ($partitura->archivo_pdf && !filter_var($partitura->archivo_pdf, FILTER_VALIDATE_URL)) {
                if (Storage::disk($disk)->exists($partitura->archivo_pdf)) {
                    Storage::disk($disk)->delete($partitura->archivo_pdf);
                }
            }

            // Guardar con el nombre original y extensión
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('partituras', $filename, $disk);
            $data['archivo_pdf'] = $path;
        }

        $this->partituraRepository->update($partitura, $data);
        return $partitura->fresh(['ritmo']);
    }

    public function delete(Partitura $partitura): bool
    {
        // Solo eliminar si no es una URL externa
        if ($partitura->archivo_pdf && !filter_var($partitura->archivo_pdf, FILTER_VALIDATE_URL)) {
            $disk = 'public';
            if (Storage::disk($disk)->exists($partitura->archivo_pdf)) {
                Storage::disk($disk)->delete($partitura->archivo_pdf);
            }
        }

        return $this->partituraRepository->delete($partitura);
    }

    public function getUrl(Partitura $partitura): ?string
    {
        if (!$partitura->archivo_pdf) {
            return null;
        }

        if (filter_var($partitura->archivo_pdf, FILTER_VALIDATE_URL)) {
            return $partitura->archivo_pdf;
        }

        $disk = 'public';
        return Storage::disk($disk)->url($partitura->archivo_pdf);
    }
}

