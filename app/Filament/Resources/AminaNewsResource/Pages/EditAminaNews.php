<?php

namespace App\Filament\Resources\AminaNewsResource\Pages;

use App\Filament\Resources\AminaNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAminaNews extends EditRecord
{
    protected static string $resource = AminaNewsResource::class;

    protected static ?string $title = 'Изменить новость';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
