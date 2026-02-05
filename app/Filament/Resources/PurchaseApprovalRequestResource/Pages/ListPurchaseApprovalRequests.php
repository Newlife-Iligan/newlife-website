<?php

namespace App\Filament\Resources\PurchaseApprovalRequestResource\Pages;

use App\Filament\Resources\PurchaseApprovalRequestResource;
use App\Models\PurchaseApprovalRequest;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseApprovalRequests extends ListRecords
{
    protected static string $resource = PurchaseApprovalRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function ($record) {
                    $items = $record->items;
                    $total = 0;
                    try {
                        foreach ($items as $item) {
                            $amount = $item["unit_price"];
                            $total += (float)$amount;
                        }
                        $rec = PurchaseApprovalRequest::find($record->id);
                        $rec->total_amount = $total;
                        $rec->save();
                    }catch (\Exception $exception){
                        Notification::make()
                            ->danger()
                            ->title('Total Amount Update Failed')
                            ->body($exception->getMessage())
                            ->send();
                    }
                })
                ->label('New Request'),
        ];
    }
}
