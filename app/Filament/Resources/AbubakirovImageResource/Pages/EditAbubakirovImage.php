<?php

namespace App\Filament\Resources\AbubakirovImageResource\Pages;

use App\Filament\Resources\AbubakirovImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbubakirovImage extends EditRecord
{
    protected static string $resource = AbubakirovImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
