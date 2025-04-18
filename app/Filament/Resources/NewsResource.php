<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use App\Models\Project;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $pluralLabel = 'Новости';
    protected static ?string $navigationLabel = 'Все новости';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public ?Model $record = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->label('Текст новости')
                    ->columnSpanFull(),



                FileUpload::make('images')
                    ->label('Фотографии')
                    ->multiple()
                    ->directory('news/images'),
                FileUpload::make('video')
                    ->label('Загрузить видео')
                    ->multiple()
                    ->directory('news/video'),
                TextInput::make('link_to_video')
                    ->label('Ссылка на видео'),
                DatePicker::make('date')
                    ->label('Дата'),
                Section::make('Для проектов:')
                    ->schema([
                    CheckBoxList::make('projects')
                    ->relationship('projects', 'name')
                ]),




                Checkbox::make('active')
                    ->label('Новость активна')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('projects.name')
                    ->label('Проект'),
                TextColumn::make('title')
                    ->label('Название'),
                ImageColumn::make('images')
                    ->label('Фотографии')
                    ->square(),
                TextColumn::make('date')
                    ->label('Дата'),
                IconColumn::make('active')
                    ->boolean()
                    ->label('Новость активна')
            ])
            ->filters([
                SelectFilter::make('projects.0.name')
                ->multiple()
                ->options(Project::all()->pluck('name', 'id')->toArray())
                    ->label('Поиск по проекту'),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
