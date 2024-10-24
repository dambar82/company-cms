<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbubakirovImageResource\Pages\CreateAbubakirovImage;
use App\Filament\Resources\AbubakirovImageResource\Pages\EditAbubakirovImage;
use App\Filament\Resources\AbubakirovImageResource\Pages\ListAbubakirovImage;
use App\Filament\Resources\AbubakirovImageResource\RelationManagers\AbubakirovImagesRelationManager;
use App\Models\ImageGallery;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbubakirovImageResource extends Resource
{
    protected static ?string $navigationGroup = 'Abubakirov';
    protected static ?string $model = ImageGallery::class;
    protected static ?string $navigationLabel = 'Изображения';
    protected static ?string $pluralLabel = 'Изображения Абубакиров';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public ?Model $record = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Textarea   ::make('title')
                    ->label('Описание')
                    ->required(),
                FileUpload::make('caption')
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
                TextColumn::make('projects.name')
                    ->label('Проект')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->join('image_gallery_project AS np', 'np.image_gallery_id', '=', 'image_galleries.id') // Присоединяем сводную таблицу по id видео
                            ->join('projects', 'projects.id', '=', 'np.project_id') // Присоединяем таблицу проектов по project_id
                            ->where('np.project_id', 2) // Фильтруем по id проекта
                            ->orderBy('projects.name', $direction) // Сортируем по имени проекта
                            ->select('image_galleries.*'); // Выбираем все поля из таблицы видео
                    }),
                TextColumn::make('name')
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
            ->persistSortInSession()
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
            AbubakirovImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAbubakirovImage::route('/'),
            'create' => CreateAbubakirovImage::route('/create'),
            'edit' => EditAbubakirovImage::route('/{record}/edit'),
        ];
    }
}
