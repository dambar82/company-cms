<?php

namespace App\Filament\Resources\AminaAudioResource\Pages;

use App\Filament\Resources\AminaAudioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAminaAudio extends EditRecord
{
    protected static string $resource = AminaAudioResource::class;

    protected static ?string $title = 'Изменить аудио';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
