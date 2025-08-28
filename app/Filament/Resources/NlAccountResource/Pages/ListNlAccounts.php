<?php

namespace App\Filament\Resources\NlAccountResource\Pages;

use App\Filament\Resources\NlAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNlAccounts extends ListRecords
{
    protected static string $resource = NlAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('md'),
        ];
    }
}
