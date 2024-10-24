<?php

namespace App\Filament\Resources\AminaVideoResource\Pages;

use App\Filament\Resources\AminaVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAminaVideos extends ListRecords
{
    protected static string $resource = AminaVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
          //  Actions\CreateAction::make(),
        ];
    }
}
