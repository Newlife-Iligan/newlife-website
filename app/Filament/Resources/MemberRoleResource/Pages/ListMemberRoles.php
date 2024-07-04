<?php

namespace App\Filament\Resources\MemberRoleResource\Pages;

use App\Filament\Resources\MemberRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemberRoles extends ListRecords
{
    protected static string $resource = MemberRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('md')
                ->label('New Role'),
        ];
    }
}
