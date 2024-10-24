<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbubakirovVideoResource\Pages\CreateAbubakirovVideoGallery;
use App\Filament\Resources\AbubakirovVideoResource\Pages\EditAbubakirovVideoGallery;
use App\Filament\Resources\AbubakirovVideoResource\Pages\ListAbubakirovVideoGalleries;
use App\Filament\Resources\AbubakirovVideoResource\RelationManagers\AbubakirovVideosRelationManager;
use App\Models\VideoGallery;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AbubakirovVideoResource extends Resource
{
    protected static ?string $navigationGroup = 'Abubakirov';

    protected static ?string $model = VideoGallery::class;
    protected static ?string $navigationLabel = 'Видео';
    protected static ?string $pluralLabel = 'Видео Абубакиров';

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                TextColumn::make('projects.name')
                    ->label('Проект')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->join('video_gallery_project AS np', 'np.video_gallery_id', '=', 'video_galleries.id') // Присоединяем сводную таблицу по id видео
                            ->join('projects', 'projects.id', '=', 'np.project_id') // Присоединяем таблицу проектов по project_id
                            ->where('np.project_id', 2) // Фильтруем по id проекта
                            ->orderBy('projects.name', $direction) // Сортируем по имени проекта
                            ->select('video_galleries.*'); // Выбираем все поля из таблицы видео
                    }),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                ,
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
            'index' => ListAbubakirovVideoGalleries::route('/'),
            'create' => CreateAbubakirovVideoGallery::route('/create'),
            'edit' => EditAbubakirovVideoGallery::route('/{record}/edit'),
        ];
    }
}
