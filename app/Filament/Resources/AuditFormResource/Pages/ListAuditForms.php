<?php

namespace App\Filament\Resources\AuditFormResource\Pages;

use App\Filament\Resources\AuditFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuditForms extends ListRecords
{
    protected static string $resource = AuditFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New')
        ];
    }
}
