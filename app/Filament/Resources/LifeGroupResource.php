<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LifeGroupResource\Pages;
use App\Filament\Resources\MinistryResource\RelationManagers\MembersRelationManager;
use App\Models\LifeGroup;
use App\Models\Members;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LifeGroupResource extends Resource
{
    protected static ?string $model = LifeGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textinput::make('name')
                    ->required()
                    ->label('Name'),

                Select::make('leader_id')
                    ->label('Leader')
                    ->required()
                    ->options(Members::all()->pluck('full_name', 'id')),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('leader_id')
                    ->label('Leader')
                    ->formatStateUsing(fn($state) => ucfirst(Members::find ($state)->full_name)),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('md'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLifeGroups::route('/'),
//            'create' => Pages\CreateLifeGroup::route('/create'),
            'edit' => Pages\EditLifeGroup::route('/{record}/edit'),
        ];
    }
}
