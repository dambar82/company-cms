<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages\CreateQuestion;
use App\Filament\Resources\QuestionResource\Pages\EditQuestion;
use App\Filament\Resources\QuestionResource\Pages\ListQuestions;
use App\Filament\Resources\QuestionResource\RelationManagers\AnswerRelationManager;
use App\Models\Quiz\Question;
use App\Models\Quiz\Quiz;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                Select::make('quiz_id')
                    ->label('Выберете викторину')
                    ->options(
                    Quiz::all()->pluck('name', 'id')->toArray()
                    )
                    ->required(),
                TextInput::make('question')
                    ->label('Вопрос')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image')
                    ->label('Изображение')
                    ->imageEditor()
                    ->image()
                    ->directory('questions'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->searchable()
                    ->label('Вопрос'),
                TextColumn::make('quiz.name')
                    ->searchable()
                    ->label('Название викторины'),
                ImageColumn::make('image')
                    ->label('Изображение'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
                EditAction::make()->label('Изменить'),
                DeleteAction::make()->label('Удалить'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListQuestions::route('/'),
            'create' => CreateQuestion::route('/create'),
            'edit' => EditQuestion::route('/{record}/edit'),
        ];
    }
}
