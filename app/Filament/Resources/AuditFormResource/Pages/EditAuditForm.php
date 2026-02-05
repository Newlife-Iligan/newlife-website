<?php

namespace App\Filament\Resources\AuditFormResource\Pages;

use App\Filament\Resources\AuditFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuditForm extends EditRecord
{
    protected static string $resource = AuditFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
