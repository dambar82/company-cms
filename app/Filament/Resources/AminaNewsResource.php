<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AminaNewsResource\Pages;
use App\Models\AminaNews;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AminaNewsResource extends Resource
{
    protected static ?string $navigationGroup = 'Амина';
    protected static ?string $pluralLabel = 'Новости';
    protected static ?string $model = AminaNews::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название'),
                FileUpload::make('images')
                    ->label('Фотографии')
                    ->multiple()
                    ->directory('amina/news'),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название'),
                ImageColumn::make('images')
                    ->label('Фотографии')
                    ->square(),
            ])
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
            'index' => Pages\ListAminaNews::route('/'),
            'create' => Pages\CreateAminaNews::route('/create'),
            'edit' => Pages\EditAminaNews::route('/{record}/edit'),
        ];
    }
}
