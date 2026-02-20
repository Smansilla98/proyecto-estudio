<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TamborResource\Pages;
use App\Models\Tambor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TamborResource extends Resource
{
    protected static ?string $model = Tambor::class;

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';
    
    protected static ?string $navigationLabel = 'Tambores';
    
    protected static ?string $modelLabel = 'Tambor';
    
    protected static ?string $pluralModelLabel = 'Tambores';
    
    protected static ?string $navigationGroup = 'Contenido';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Tambor')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre del Tambor')
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Textarea::make('descripcion')
                            ->rows(3)
                            ->label('Descripción')
                            ->columnSpanFull(),
                    ]),
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
                
                Tables\Columns\TextColumn::make('descripcion')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->descripcion)
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('ritmos_count')
                    ->counts('ritmos')
                    ->label('Ritmos')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('videos_count')
                    ->counts('videos')
                    ->label('Videos')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nombre');
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
            'index' => Pages\ListTambores::route('/'),
            'create' => Pages\CreateTambor::route('/create'),
            'edit' => Pages\EditTambor::route('/{record}/edit'),
        ];
    }
}

