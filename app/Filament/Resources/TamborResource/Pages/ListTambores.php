<?php

namespace App\Filament\Resources\TamborResource\Pages;

use App\Filament\Resources\TamborResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTambores extends ListRecords
{
    protected static string $resource = TamborResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

