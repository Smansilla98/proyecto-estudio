<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartituraResource\Pages;
use App\Models\Partitura;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartituraResource extends Resource
{
    protected static ?string $model = Partitura::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Partituras';
    
    protected static ?string $modelLabel = 'Partitura';
    
    protected static ?string $pluralModelLabel = 'Partituras';
    
    protected static ?string $navigationGroup = 'Contenido';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Partitura')
                    ->schema([
                        Forms\Components\Select::make('ritmo_id')
                            ->relationship('ritmo', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Ritmo'),
                    ]),
                
                Forms\Components\Section::make('Archivo PDF')
                    ->schema([
                        Forms\Components\FileUpload::make('archivo_pdf')
                            ->label('Archivo PDF')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(102400) // 100MB
                            ->directory('partituras')
                            ->required()
                            ->helperText('Formato: PDF (máx. 100MB)')
                            ->columnSpanFull()
                            ->disk('public'),
                    ])
                    ->description('Sube el archivo PDF de la partitura'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ritmo.nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('archivo_pdf')
                    ->label('Archivo')
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->archivo_pdf),
                
                Tables\Columns\IconColumn::make('archivo_pdf')
                    ->label('Tipo')
                    ->icon('heroicon-o-document-text')
                    ->color('danger'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ritmo_id')
                    ->relationship('ritmo', 'nombre')
                    ->label('Ritmo')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver/Reproducir')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Partitura $record) => route('partituras.show', $record))
                    ->openUrlInNewTab()
                    ->color('success'),
                
                Tables\Actions\Action::make('download')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Partitura $record) => \Storage::disk('public')->url($record->archivo_pdf))
                    ->openUrlInNewTab()
                    ->color('primary'),
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListPartituras::route('/'),
            'create' => Pages\CreatePartitura::route('/create'),
            'edit' => Pages\EditPartitura::route('/{record}/edit'),
        ];
    }
}

