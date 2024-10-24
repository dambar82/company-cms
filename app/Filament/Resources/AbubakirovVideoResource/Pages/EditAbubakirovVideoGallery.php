<?php

namespace App\Filament\Resources\AbubakirovVideoResource\Pages;

use App\Filament\Resources\AbubakirovVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbubakirovVideoGallery extends EditRecord
{
    protected static string $resource = AbubakirovVideoResource::class;

    protected static ?string $title = 'Изменить видеогалерею';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
