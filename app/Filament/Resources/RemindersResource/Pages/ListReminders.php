<?php

namespace App\Filament\Resources\RemindersResource\Pages;

use App\Filament\Resources\RemindersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReminders extends ListRecords
{
    protected static string $resource = RemindersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('xl'),
        ];
    }
}
