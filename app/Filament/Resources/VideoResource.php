<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    
    protected static ?string $navigationLabel = 'Videos';
    
    protected static ?string $modelLabel = 'Video';
    
    protected static ?string $pluralModelLabel = 'Videos';
    
    protected static ?string $navigationGroup = 'Contenido';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Video')
                    ->schema([
                        Forms\Components\Select::make('ritmo_id')
                            ->relationship('ritmo', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Ritmo'),
                        
                        Forms\Components\Select::make('tambor_id')
                            ->relationship('tambor', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Tambor'),
                        
                        Forms\Components\TextInput::make('orden_ejecucion')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->label('Orden de Ejecución')
                            ->helperText('Orden en que se ejecuta este video en el ritmo'),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Archivo de Video')
                    ->schema([
                        Forms\Components\TextInput::make('url_video')
                            ->url()
                            ->label('URL del Video (opcional)')
                            ->helperText('URL externa del video (YouTube, Vimeo, etc.)')
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('video_file')
                            ->label('Archivo de Video (opcional)')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                            ->maxSize(204800) // 200MB
                            ->directory('videos')
                            ->helperText('Formatos: MP4, WebM, OGG (máx. 200MB)')
                            ->columnSpanFull()
                            ->visible(fn ($get) => empty($get('url_video')))
                            ->disk('public'),
                    ])
                    ->description('Proporciona una URL externa O sube un archivo de video')
                    ->collapsible(),
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
                
                Tables\Columns\TextColumn::make('tambor.nombre')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('orden_ejecucion')
                    ->label('Orden')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\IconColumn::make('url_video')
                    ->label('Tipo')
                    ->icon(fn ($record) => $record->url_video ? 'heroicon-o-link' : 'heroicon-o-film')
                    ->tooltip(fn ($record) => $record->url_video ? 'URL Externa' : 'Archivo Local'),
                
                Tables\Columns\TextColumn::make('url_video')
                    ->label('URL')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->url_video)
                    ->toggleable()
                    ->visible(fn ($record) => !empty($record->url_video)),
                
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
                
                Tables\Filters\SelectFilter::make('tambor_id')
                    ->relationship('tambor', 'nombre')
                    ->label('Tambor')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Video $record) => $record->url_video ?: '#')
                    ->openUrlInNewTab()
                    ->visible(fn (Video $record) => !empty($record->url_video)),
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('ritmo_id')
            ->defaultSort('orden_ejecucion');
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}

