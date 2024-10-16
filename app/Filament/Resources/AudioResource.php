<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AminaAudioResource\Pages;
use App\Models\Audio;
use App\Models\Project;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AudioResource extends Resource
{
    protected static ?string $pluralLabel = 'Аудио';
    protected static ?string $model = Audio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->label('Проект')
                    ->options(Project::all()->pluck('name', 'id')->toArray())
                    ->required(),
                TextInput::make('title')
                ->label('Название'),
                FileUpload::make('path')
                ->label('Аудио')
                ->directory('audio')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Проект')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Название')
            ])
            ->filters([
                SelectFilter::make('project_id')
                    ->options(Project::all()->pluck('name', 'id')->toArray())
                    ->label('Выберете проект')
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
