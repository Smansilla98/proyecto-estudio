<?php

namespace App\Filament\Resources\PartituraResource\Pages;

use App\Filament\Resources\PartituraResource;
use App\Services\PartituraService;
use Filament\Resources\Pages\CreateRecord;

class CreatePartitura extends CreateRecord
{
    protected static string $resource = PartituraResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Filament ya guardó el archivo, el path está en $data['archivo_pdf']
        // No necesitamos hacer nada más, Filament maneja la subida
        return $data;
    }
    
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Filament ya guardó el archivo, el path está en $data['archivo_pdf']
        // Crear directamente el modelo ya que Filament maneja la subida
        return \App\Models\Partitura::create($data);
    }
}

