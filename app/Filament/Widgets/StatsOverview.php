<?php

namespace App\Filament\Widgets;

use App\Models\Ritmo;
use App\Models\Tambor;
use App\Models\Video;
use App\Models\Partitura;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Ritmos', Ritmo::count())
                ->description('Ritmos en el sistema')
                ->descriptionIcon('heroicon-m-musical-note')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5]),
            
            Stat::make('Ritmos Aprobados', Ritmo::where('approved', true)->count())
                ->description('Ritmos disponibles para alumnos')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Total Alumnos', User::role('alumno')->count())
                ->description('Usuarios con rol alumno')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            
            Stat::make('Total Videos', Video::count())
                ->description('Videos subidos')
                ->descriptionIcon('heroicon-m-video-camera')
                ->color('warning'),
            
            Stat::make('Total Partituras', Partitura::count())
                ->description('Partituras disponibles')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            
            Stat::make('Total Tambores', Tambor::count())
                ->description('Tipos de tambores')
                ->descriptionIcon('heroicon-m-speaker-wave')
                ->color('danger'),
        ];
    }
}

