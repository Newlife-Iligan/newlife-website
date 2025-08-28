<?php

namespace App\Filament\Resources\NlAccountResource\Pages;

use App\Filament\Resources\NlAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNlAccount extends EditRecord
{
    protected static string $resource = NlAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
