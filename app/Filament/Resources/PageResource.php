<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPage;
use App\Models\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class PageResource extends Resource
{
    protected static ?string $model = Pages::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Страницы';
    protected static ?string $pluralLabel = 'Страницы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Checkbox::make('is_visible')
                    ->label('видимость'),
                Forms\Components\FileUpload::make('caption')
                    ->label('Изображение')
                    ->imageEditor()
                    ->image()
                    ->directory('pages/captions'),
                Forms\Components\Textarea::make('short_description')
                    ->label('Краткое описание')
                    ->required(),
                Forms\Components\RichEditor::make('full_content')
                    ->label('Текст страницы')
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
                        'undo'
                    ])
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date')
                    ->label('Дата')
                    ->required(),
                Forms\Components\FileUpload::make('images')
                    ->label('Фотографии')
                    ->multiple()
                    ->imageEditor()
                    ->image()
                    ->directory('pages/images'),
                Forms\Components\TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->maxLength(255)
                    ->nullable(),
                Forms\Components\Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->nullable(),
                Forms\Components\TextInput::make('url')
                    ->label('Page URL')
                    ->required()
                    ->maxLength(255)
                    ->rules(function ($record) {
                        return [
                            Rule::unique('pages', 'url')->ignore($record?->id),
                        ];
                    }),
                Forms\Components\Checkbox::make('can_comment')
                    ->label('Allow Comments')
                    ->default(false),
                Forms\Components\Checkbox::make('can_like')
                    ->label('Allow Likes')
                    ->default(false),
            ]);

    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->label('Название'),
                Tables\Columns\IconColumn::make('is_visible')->boolean()->sortable()->label('Видимость'),
                Tables\Columns\TextColumn::make('date')->date()->sortable()->label('Дата'),
                Tables\Columns\TextColumn::make('url')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Просмотреть'),
                Tables\Actions\EditAction::make()->label('Изменить'),
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
            'index' => ListPage::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
