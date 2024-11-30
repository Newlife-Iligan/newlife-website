<?php

namespace App\Filament\Resources\NlFinanceResource\Pages;

use App\Filament\Resources\NlFinanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNlFinance extends EditRecord
{
    protected static string $resource = NlFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
