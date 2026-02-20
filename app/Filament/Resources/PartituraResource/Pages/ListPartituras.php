<?php

namespace App\Filament\Resources\PartituraResource\Pages;

use App\Filament\Resources\PartituraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartituras extends ListRecords
{
    protected static string $resource = PartituraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

