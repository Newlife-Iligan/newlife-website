<?php

namespace App\Filament\Resources\MemberRoleResource\Pages;

use App\Filament\Resources\MemberRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemberRole extends EditRecord
{
    protected static string $resource = MemberRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
