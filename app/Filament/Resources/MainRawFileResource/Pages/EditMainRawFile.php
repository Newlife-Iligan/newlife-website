<?php

namespace App\Filament\Resources\MainRawFileResource\Pages;

use App\Filament\Resources\MainRawFileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMainRawFile extends EditRecord
{
    protected static string $resource = MainRawFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
