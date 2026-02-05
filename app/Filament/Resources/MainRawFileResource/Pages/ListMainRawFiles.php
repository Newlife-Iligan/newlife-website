<?php

namespace App\Filament\Resources\MainRawFileResource\Pages;

use App\Filament\Resources\MainRawFileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMainRawFiles extends ListRecords
{
    protected static string $resource = MainRawFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
