<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MinistryResource\Pages;
use App\Filament\Resources\MinistryResource\RelationManagers;
use App\Filament\Resources\MinistryResource\RelationManagers\MembersRelationManager;
use App\Models\Ministry;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use App\Models\Members;


class MinistryResource extends Resource
{
    protected static ?string $model = Ministry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textinput::make('name')
                    ->label('Name')
                    ->required(),
                Select::make('head_id')
                    ->label("Ministry Head")
                    ->options(Members::all()->pluck('full_name', 'id'))
                    ->required(),
                Select::make('assistant_id')
                    ->label("Head Assistant")
                    ->options(Members::all()->pluck('full_name', 'id'))
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('head_id')
                    ->label('Ministry Head')
                    ->formatStateUsing(fn($state) => ucfirst(Members::find ($state)->full_name)),
                TextColumn::make('assistant_id')
                    ->label('Head Assistant')
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
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMinistries::route('/'),
//            'create' => Pages\CreateMinistry::route('/create'),
            'edit' => Pages\EditMinistry::route('/{record}/edit'),
        ];
    }
}
