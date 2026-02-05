<?php

namespace App\Filament\Resources\MembersResource\Pages;

use App\Filament\Resources\MembersResource;
use App\Models\MemberRole;
use App\Models\Members;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMembers extends ListRecords
{
    protected static string $resource = MembersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->label('New Member')
                ->modalHeading('New Member')
                ->modalWidth('md')
                ->mutateFormDataUsing(function($data){
                    $role_member = MemberRole::where('name', "Member")->firstOrFail();
                    if($role_member){
                        $data["role"] = $role_member->id;
                    }
                    return $data;
                })
            ,
        ];
    }
}
