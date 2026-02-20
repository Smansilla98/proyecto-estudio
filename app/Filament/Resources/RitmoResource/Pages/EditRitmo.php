<?php

namespace App\Filament\Resources\RitmoResource\Pages;

use App\Filament\Resources\RitmoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRitmo extends EditRecord
{
    protected static string $resource = RitmoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

