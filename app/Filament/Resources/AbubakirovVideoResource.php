<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbubakirovVideoResource\Pages\CreateVideoGallery;
use App\Filament\Resources\AbubakirovVideoResource\Pages\EditVideoGallery;
use App\Filament\Resources\AbubakirovVideoResource\Pages\ListVideoGalleries;
use App\Filament\Resources\AbubakirovVideoResource\RelationManagers\AbubakirovVideosRelationManager;
use App\Models\Project;
use App\Models\VideoGallery;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AbubakirovVideoResource extends Resource
{
    protected static ?string $navigationGroup = 'Abubakirov';

    protected static ?string $model = VideoGallery::class;
    protected static ?string $navigationLabel = 'Видео';
    protected static ?string $pluralLabel = 'Видео';

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->label('Проект')
                    ->options(Project::all()->pluck('name', 'id')->toArray())
                    ->required(),
                TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Textarea::make('title')
                    ->label('Описание')
                    ->required(),
                FileUpload::make('preview')
                    ->directory('abubakirov/preview'),
                Forms\Components\FileUpload::make('video')
                    ->directory('	abubakirov/video')
                    ->label('Видео')
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Проект')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Описание')
                    ->searchable(),
                ImageColumn::make('preview')
                ->square(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AbubakirovVideosRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideoGalleries::route('/'),
            'create' => CreateVideoGallery::route('/create'),
            'edit' => EditVideoGallery::route('/{record}/edit'),
        ];
    }
}
