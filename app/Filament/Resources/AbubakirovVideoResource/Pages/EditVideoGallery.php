<?php

namespace App\Filament\Resources\AbubakirovVideoResource\Pages;

use App\Filament\Resources\AbubakirovVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoGallery extends EditRecord
{
    protected static string $resource = AbubakirovVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
