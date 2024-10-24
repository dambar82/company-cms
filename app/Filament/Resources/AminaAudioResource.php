<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AminaAudioResource\Pages;
use App\Models\Audio;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AminaAudioResource extends Resource
{
    protected static ?string $navigationGroup = 'Amina';
    protected static ?string $navigationLabel = 'Аудио';
    protected static ?string $pluralLabel = 'Аудио Амина';

    protected static ?string $model = Audio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название'),
                FileUpload::make('path')
                    ->label('Аудио')
                    ->directory('amina/audio')
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
                            ->join('audio_project AS np', 'np.audio_id', '=', 'audios.id') // Присоединяем сводную таблицу по id аудио
                            ->join('projects', 'projects.id', '=', 'np.project_id') // Присоединяем таблицу проектов по project_id
                            ->where('np.project_id', 1) // Фильтруем по id проекта
                            ->orderBy('projects.name', $direction) // Сортируем по имени проекта
                            ->select('audios.*'); // Выбираем все поля из таблицы аудио
                    }),
                TextColumn::make('title')
                    ->label('Название')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAminaAudio::route('/'),
            'create' => Pages\CreateAminaAudio::route('/create'),
            'edit' => Pages\EditAminaAudio::route('/{record}/edit'),
        ];
    }
}
