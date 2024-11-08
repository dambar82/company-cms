<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultResource\Pages;
use App\Models\Quiz;
use App\Models\Result;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms;

class ResultResource extends Resource
{
    protected static ?string $model = Result::class;
    protected static ?string $navigationGroup = "Викторины";
    protected static ?string $navigationLabel = 'Результаты';
    protected static ?string $pluralLabel = 'Результаты';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('quiz_id')
                    ->required()
                    ->label('Выберете викторину')
                    ->placeholder('')
                    ->options(
                        Quiz::all()->pluck('name', 'id')->toArray()
                    ),
                Forms\Components\TextInput::make('result')
                    ->required()
                    ->label('Результат'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quiz.name')
                    ->searchable()
                    ->label('Название викторины'),
                Tables\Columns\TextColumn::make('result')
                    ->searchable()
                    ->label('Результат'),
            ])
            ->filters([
                SelectFilter::make('quiz_id')
                    ->multiple()
                    ->options(Quiz::all()->pluck('name', 'id')->toArray())
                    ->label('Название викторины'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Изменить'),
                Tables\Actions\DeleteAction::make()->label('Удалить'),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResults::route('/'),
            'create' => Pages\CreateResult::route('/create'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }
}
