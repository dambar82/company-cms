<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource\RelationManagers\AnswerRelationManager;
use App\Models\Question;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationGroup = "Викторины";
    protected static ?string $navigationLabel = 'Вопросы';
    protected static ?string $pluralLabel = 'Вопросы';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->label('Вопрос')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Изображение')
                    ->imageEditor()
                    ->image()
                    ->directory('questions'),
                Forms\Components\Select::make('quiz_id')
                    ->label('Выберете викторину')
                    ->options(
                        Quiz::all()->pluck('name', 'id')->toArray()
                    )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->searchable()
                    ->label('Вопрос'),
                Tables\Columns\TextColumn::make('quiz.name')
                    ->searchable()
                    ->label('Название викторины'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            AnswerRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
