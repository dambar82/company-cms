<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AudioResource\Pages;
use App\Models\Audio;
use App\Models\Project;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AudioResource extends Resource
{
    protected static ?string $model = Audio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralLabel = 'Аудио';
    protected static ?string $navigationLabel = 'Все аудио';

    public ?Model $record = null;

    public static function form(Form $form): Form
    {
            return $form
                ->schema([
                    Section::make('Для проектов:')
                        ->schema([
                            CheckBoxList::make('projects')
                                ->relationship('projects', 'name')
                        ]),
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
                TextColumn::make('projects.0.name')
                    ->label('Проект'),
                TextColumn::make('title')
                    ->label('Название')
            ])
            ->persistSortInSession()
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
            'index' => Pages\ListAudio::route('/'),
            'create' => Pages\CreateAudio::route('/create'),
            'edit' => Pages\EditAudio::route('/{record}/edit'),
        ];
    }
}
