<?php

namespace App\Filament\Resources\AbubakirovVideoResource\Pages;

use App\Filament\Resources\AbubakirovVideoResource;
use Filament\Resources\Pages\ListRecords;

class ListAbubakirovVideoGalleries extends ListRecords
{
    protected static string $resource = AbubakirovVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
}
