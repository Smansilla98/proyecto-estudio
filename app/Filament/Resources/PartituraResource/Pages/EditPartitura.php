<?php

namespace App\Filament\Resources\PartituraResource\Pages;

use App\Filament\Resources\PartituraResource;
use App\Services\PartituraService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartitura extends EditRecord
{
    protected static string $resource = PartituraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Filament ya guardó el archivo si hay uno nuevo
        // El path está en $data['archivo_pdf']
        return $data;
    }
    
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Si hay un nuevo archivo, eliminar el anterior
        if (isset($data['archivo_pdf']) && $record->archivo_pdf) {
            $oldPath = $record->archivo_pdf;
            if (!filter_var($oldPath, FILTER_VALIDATE_URL) && \Storage::disk('public')->exists($oldPath)) {
                \Storage::disk('public')->delete($oldPath);
            }
        }
        
        // Filament ya guardó el nuevo archivo si hay uno
        $record->update($data);
        return $record->fresh();
    }
}

