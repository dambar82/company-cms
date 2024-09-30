<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AminaAudioResource\Pages;
use App\Models\AminaAudio;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AminaAudioResource extends Resource
{
    protected static ?string $navigationGroup = 'Амина';
    protected static ?string $pluralLabel = 'Аудио';
    protected static ?string $model = AminaAudio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                ->label('Название'),
                FileUpload::make('path')
                ->label('Аудио')
                ->directory('amina/audio')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
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
            'index' => Pages\ListAminaAudio::route('/'),
            'create' => Pages\CreateAminaAudio::route('/create'),
            'edit' => Pages\EditAminaAudio::route('/{record}/edit'),
        ];
    }
}
