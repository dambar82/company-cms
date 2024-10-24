<?php

namespace App\Filament\Resources\AminaVideoResource\Pages;

use App\Filament\Resources\AminaVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAminaVideo extends EditRecord
{
    protected static ?string $title = 'Изменить видеогалерею';

    protected static string $resource = AminaVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
