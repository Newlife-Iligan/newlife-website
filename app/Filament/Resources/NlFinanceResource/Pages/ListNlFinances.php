<?php

namespace App\Filament\Resources\NlFinanceResource\Pages;

use App\Filament\Resources\NlFinanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNlFinances extends ListRecords
{
    protected static string $resource = NlFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
                ->slideOver()
                ->modalWidth('lg')
                ->modalHeading('NewLife Finance Form'),
        ];
    }
}
