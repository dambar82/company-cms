<?php

namespace App\Filament\Resources\AminaAudioResource\Pages;

use App\Filament\Resources\AminaAudioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAminaAudio extends ListRecords
{
    protected static string $resource = AminaAudioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
