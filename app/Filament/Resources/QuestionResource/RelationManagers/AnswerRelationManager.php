<?php

namespace App\Filament\Resources\QuestionResource\RelationManagers;

use App\Models\Answer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnswerRelationManager extends RelationManager
{
    protected static string $relationship = 'answer';
    protected static ?string $title = 'Ответы';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('answer')
                    ->label('Ответ')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('correct_answer')
                    ->label('Выберете значение')
                    ->options(
                        [
                            0 => 'правильный ответ',
                            1 => 'неправильный ответ'
                        ]
                    )
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('answer')
            ->columns([
                Tables\Columns\TextColumn::make('answer')
                    ->label('Ответ'),
                Tables\Columns\IconColumn::make('correct_answer')
                    ->boolean()
                    ->label('Правильный ответ')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Создать'),
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
}
