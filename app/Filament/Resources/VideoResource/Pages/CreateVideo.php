<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use App\Services\VideoService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;

class CreateVideo extends CreateRecord
{
    protected static string $resource = VideoResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Filament ya guardó el archivo, ahora solo necesitamos el path
        if (isset($data['video_file']) && is_string($data['video_file'])) {
            // El path ya está guardado por Filament, solo asignarlo a url_video
            $data['url_video'] = $data['video_file'];
            unset($data['video_file']);
        }
        
        return $data;
    }
    
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Filament ya guardó el archivo si hay uno, el path está en $data['video_file']
        // Si hay archivo, asignarlo a url_video
        if (isset($data['video_file']) && is_string($data['video_file'])) {
            $data['url_video'] = $data['video_file'];
            unset($data['video_file']);
        }
        
        // Crear directamente el modelo ya que Filament maneja la subida
        return \App\Models\Video::create($data);
    }
}

