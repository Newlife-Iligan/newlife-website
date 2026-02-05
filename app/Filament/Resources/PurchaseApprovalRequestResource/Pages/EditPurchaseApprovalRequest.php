<?php

namespace App\Filament\Resources\PurchaseApprovalRequestResource\Pages;

use App\Filament\Resources\PurchaseApprovalRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseApprovalRequest extends EditRecord
{
    protected static string $resource = PurchaseApprovalRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
