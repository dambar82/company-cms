<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageGalleryResource\Pages;
use App\Models\ImageGallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ImageGalleryResource\RelationManagers\ImagesRelationManager;

class ImageGalleryResource extends Resource
{
    protected static ?string $model = ImageGallery::class;
    protected static ?string $navigationLabel = 'Изображения';
    protected static ?string $navigationGroup = 'Абубакиров';
    protected static ?string $pluralLabel = 'Изображения';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Forms\Components\Textarea   ::make('title')
                    ->label('Описание')
                    ->required(),
                Forms\Components\FileUpload::make('caption')
                    ->directory('abubakirov/gallery')
                    ->label('Изображение')
                    ->imageEditor()
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Описание')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('caption')
                    ->label('Изображение'),
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
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImageGalleries::route('/'),
            'create' => Pages\CreateImageGallery::route('/create'),
            'edit' => Pages\EditImageGallery::route('/{record}/edit'),
        ];
    }
}
