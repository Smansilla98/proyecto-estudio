<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RitmoResource\Pages;
use App\Models\Ritmo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RitmoResource extends Resource
{
    protected static ?string $model = Ritmo::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    
    protected static ?string $navigationLabel = 'Ritmos';
    
    protected static ?string $modelLabel = 'Ritmo';
    
    protected static ?string $pluralModelLabel = 'Ritmos';
    
    protected static ?string $navigationGroup = 'Contenido';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre del Ritmo'),
                        
                        Forms\Components\Textarea::make('descripcion')
                            ->rows(3)
                            ->label('Descripción'),
                        
                        Forms\Components\TextInput::make('bpm_default')
                            ->numeric()
                            ->required()
                            ->default(120)
                            ->label('BPM por Defecto')
                            ->helperText('Beats por minuto'),
                        
                        Forms\Components\TextInput::make('autor')
                            ->maxLength(255)
                            ->label('Autor/Adaptación'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Clasificación')
                    ->schema([
                        Forms\Components\Select::make('anio')
                            ->options([
                                1 => '1er Año',
                                2 => '2do Año',
                                3 => '3er Año',
                                4 => '4to Año',
                                5 => '5to Año',
                                6 => '6to Año',
                            ])
                            ->label('Año')
                            ->native(false),
                        
                        Forms\Components\TextInput::make('tipo')
                            ->maxLength(255)
                            ->label('Tipo de Ritmo'),
                        
                        Forms\Components\Toggle::make('opcional')
                            ->label('Es Opcional')
                            ->default(false),
                        
                        Forms\Components\TextInput::make('anio_opcional')
                            ->numeric()
                            ->label('Año Opcional')
                            ->visible(fn (Forms\Get $get) => $get('opcional')),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Tambores')
                    ->schema([
                        Forms\Components\Select::make('tambores')
                            ->relationship('tambores', 'nombre')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Tambores del Ritmo')
                            ->helperText('Selecciona los tambores que se usan en este ritmo'),
                    ]),
                
                Forms\Components\Section::make('Estado y Permisos')
                    ->schema([
                        Forms\Components\Select::make('created_by')
                            ->relationship('creador', 'name')
                            ->required()
                            ->default(fn () => auth()->id())
                            ->label('Creado por')
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\Toggle::make('approved')
                            ->label('Aprobado')
                            ->default(false)
                            ->helperText('Los ritmos aprobados son visibles para los alumnos'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('bpm_default')
                    ->label('BPM')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('tambores.nombre')
                    ->label('Tambores')
                    ->badge()
                    ->separator(',')
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('anio')
                    ->label('Año')
                    ->formatStateUsing(fn ($state) => $state ? ($state == 1 ? '1er' : ($state == 2 ? '2do' : ($state == 3 ? '3er' : ($state == 4 ? '4to' : ($state == 5 ? '5to' : ($state == 6 ? '6to' : $state))))) . ' Año' : '-')
                    ->badge()
                    ->color('warning'),
                
                Tables\Columns\IconColumn::make('approved')
                    ->label('Aprobado')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('creador.name')
                    ->label('Creado por')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('videos_count')
                    ->counts('videos')
                    ->label('Videos')
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('partituras_count')
                    ->counts('partituras')
                    ->label('Partituras')
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('approved')
                    ->label('Estado')
                    ->options([
                        true => 'Aprobados',
                        false => 'Pendientes',
                    ]),
                
                Tables\Filters\SelectFilter::make('anio')
                    ->label('Año')
                    ->options([
                        1 => '1er Año',
                        2 => '2do Año',
                        3 => '3er Año',
                        4 => '4to Año',
                        5 => '5to Año',
                        6 => '6to Año',
                    ]),
                
                Tables\Filters\Filter::make('opcional')
                    ->label('Solo Opcionales')
                    ->query(fn (Builder $query): Builder => $query->where('opcional', true)),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (Ritmo $record) => $record->update(['approved' => true]))
                    ->requiresConfirmation()
                    ->visible(fn (Ritmo $record) => !$record->approved),
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Aprobar Seleccionados')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['approved' => true]))
                        ->requiresConfirmation(),
                    
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRitmos::route('/'),
            'create' => Pages\CreateRitmo::route('/create'),
            'edit' => Pages\EditRitmo::route('/{record}/edit'),
        ];
    }
}

