<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AminaVideoResource\Pages;
use App\Filament\Resources\AminaVideoResource\RelationManagers\VideoRelationManager;
use App\Models\Project;
use App\Models\VideoGallery;
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

class AminaVideoResource extends Resource
{
    protected static ?string $navigationGroup = 'Amina';
    protected static ?string $pluralLabel = 'Видео';
    protected static ?string $navigationLabel = 'Видео';

    protected static ?string $model = VideoGallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Select::make('project_id')
//                    ->label('Проект')
//                    ->options(Project::all()->pluck('name', 'id')->toArray())
//                    ->required(),
                TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Textarea::make('title')
                    ->label('Описание')
                    ->required(),
                FileUpload::make('preview')
                    ->directory('amina/preview'),
                FileUpload::make('video')
                    ->directory('amina/video')
                    ->label('Видео')
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('projects.0.name')
                    ->label('Проект'),
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
            ->persistSortInSession()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            VideoRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAminaVideos::route('/'),
            'create' => Pages\CreateAminaVideo::route('/create'),
            'edit' => Pages\EditAminaVideo::route('/{record}/edit'),
        ];
    }
}
