<?php

namespace App\Filament\Resources\AminaNewsResource\Pages;

use App\Filament\Resources\AminaNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAminaNews extends ListRecords
{
    protected static string $resource = AminaNewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
