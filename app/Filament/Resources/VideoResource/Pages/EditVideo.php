<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use App\Services\VideoService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideo extends EditRecord
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Si hay un nuevo archivo de video, Filament ya lo guardó
        if (isset($data['video_file']) && is_string($data['video_file'])) {
            // El path ya está guardado por Filament, solo asignarlo a url_video
            $data['url_video'] = $data['video_file'];
            unset($data['video_file']);
        }
        
        return $data;
    }
    
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Si hay un nuevo archivo, eliminar el anterior
        if (isset($data['video_file']) && is_string($data['video_file'])) {
            $data['url_video'] = $data['video_file'];
            unset($data['video_file']);
            
            // Eliminar archivo anterior si existe
            if ($record->url_video && !filter_var($record->url_video, FILTER_VALIDATE_URL)) {
                if (\Storage::disk('public')->exists($record->url_video)) {
                    \Storage::disk('public')->delete($record->url_video);
                }
            }
        }
        
        // Filament ya guardó el nuevo archivo si hay uno
        $record->update($data);
        return $record->fresh();
    }
}

