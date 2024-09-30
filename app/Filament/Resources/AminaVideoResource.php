<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AminaVideoResource\Pages;
use App\Models\AminaVideo;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AminaVideoResource extends Resource
{
    protected static ?string $navigationGroup = 'Амина';
    protected static ?string $pluralLabel = 'Видео';
    protected static ?string $model = AminaVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название'),
                FileUpload::make('path')
                    ->label('Видео')
                    ->directory('amina/videos/video'),
                FileUpload::make('preview')
                    ->label('Превью')
                    ->directory('amina/videos/preview')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название'),
                ImageColumn::make('preview')
                    ->label('Превью')
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
            'index' => Pages\ListAminaVideos::route('/'),
            'create' => Pages\CreateAminaVideo::route('/create'),
            'edit' => Pages\EditAminaVideo::route('/{record}/edit'),
        ];
    }
}
