<?php
//
//namespace App\Filament\Resources;
//
//use App\Filament\Resources\AnswerResource\Pages;
//use App\Models\Answer;
//use App\Models\Question;
//use Filament\Forms;
//use Filament\Forms\Form;
//use Filament\Resources\Resource;
//use Filament\Tables;
//use Filament\Tables\Filters\SelectFilter;
//use Filament\Tables\Table;
//
//class AnswerResource extends Resource
//{
//    protected static ?string $model = Answer::class;
//    protected static ?string $navigationGroup = "Викторины";
//    protected static ?string $navigationLabel = 'Ответы';
//    protected static ?string $pluralLabel = 'Ответы';
//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
//
//    public static function form(Form $form): Form
//    {
//        return $form
//            ->schema([
//                Forms\Components\TextInput::make('answer')
//                    ->label('Ответ')
//                    ->required()
//                    ->maxLength(255),
//                Forms\Components\Select::make('question_id')
//                    ->placeholder('')
//                    ->label('Выберете вопрос')
//                    ->options(
//                        Question::all()->pluck('question', 'id')->toArray()
//                    ),
//                Forms\Components\Select::make('correct_answer')
//                    ->label('Правильный ответ')
//                    ->placeholder('Выберете значение')
//                    ->options(
//                        [
//                            0 => 'не правильное',
//                            1 => 'правильное'
//                        ]
//                    ),
//
//            ]);
//    }
//
//    public static function table(Table $table): Table
//    {
//        return $table
//            ->columns([
//                Tables\Columns\TextColumn::make('question.question')
//                    ->searchable()
//                    ->label('Вопрос'),
//                Tables\Columns\TextColumn::make('answer')
//                    ->searchable()
//                    ->label('Ответ'),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//            ])
//            ->filters([
//                SelectFilter::make('question_id')
//                    ->multiple()
//                    ->options(Question::all()->pluck('question', 'id')->toArray())
//                    ->label('Поиск по вопросу'),
//            ])
//            ->actions([
//                Tables\Actions\EditAction::make()->label('Изменить'),
//                Tables\Actions\DeleteAction::make()->label('Удалить'),
//            ])
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ]);
//    }
//
//    public static function getRelations(): array
//    {
//        return [
//        ];
//    }
//
//    public static function getPages(): array
//    {
//        return [
//            'index' => Pages\ListAnswers::route('/'),
//            'create' => Pages\CreateAnswer::route('/create'),
//            'edit' => Pages\EditAnswer::route('/{record}/edit'),
//        ];
//    }
//}
