<?php

namespace App\Filament\Resources\RemindersResource\Pages;

use App\Filament\Resources\RemindersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReminders extends EditRecord
{
    protected static string $resource = RemindersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
