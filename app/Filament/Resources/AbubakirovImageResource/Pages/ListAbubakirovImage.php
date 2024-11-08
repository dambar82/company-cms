<?php

namespace App\Filament\Resources\AbubakirovImageResource\Pages;

use App\Filament\Resources\AbubakirovImageResource;
use Filament\Resources\Pages\ListRecords;

class ListAbubakirovImage extends ListRecords
{
    protected static string $resource = AbubakirovImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
           //  Actions\CreateAction::make(),
        ];
    }
}
