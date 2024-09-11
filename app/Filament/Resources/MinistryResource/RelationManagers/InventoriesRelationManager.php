<?php

namespace App\Filament\Resources\MinistryResource\RelationManagers;

use App\Models\Members;
use App\Models\Ministry;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'inventories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fileupload::make('image')
                    ->image()
                    ->disk('public')
                    ->label('Image')
                    ->optimize('webp')
                    ->directory('inventory_pic')
                    ->required(),
                TextInput::make('name')
                    ->label('Item Name')
                    ->required(),
                TextInput::make('brand')
                    ->label('Brand')
                    ->required(),
                TextInput::make('model')
                    ->label('Model')
                    ->required(),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->required(),
                TextInput::make('market_value')
                    ->label('Market Value')
                    ->placeholder('₱')
                    ->numeric()
                    ->required(),
                TextInput::make('category')
                    ->label('Category')
                    ->required(),
                TextArea::make('description')
                    ->label('Description')
                    ->required(),
                Datepicker::make('inventory_date')
                    ->label('Inventory Date')
                    ->required(),
                Select::make('assign_to')
                    ->options(Members::all()->pluck('full_name', 'id')),
                Select::make('counted_by')
                    ->options(Members::all()->pluck('full_name', 'id')),
                ToggleButtons::make('status')
                    ->options([
                        1 => "Active",
                        0 => "Inactive",
                    ])
                    ->colors([
                        1 => "success",
                        0 => "danger",
                    ])
                    ->default(1)
                    ->inline()
                    ->grouped(),
                Select::make('ministry_id')
                    ->options(Ministry::all()->pluck('name','id'))
                    ->label('Ministry'),

            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image')
                    ->label('Image'),
                TextColumn::make('name')
                    ->label('Item Name'),
                TextColumn::make('model')
                    ->label('Model'),
                TextColumn::make('quantity')
                    ->label('Quantity'),
                TextColumn::make('market_value')
                    ->label('Market Value'),
                TextColumn::make('category')
                    ->label('Category'),
                TextColumn::make('description')
                    ->label('Description')
                    ->words(5)
                    ->tooltip(fn($record) => $record->description),
                TextColumn::make('inventory_date')
                    ->label('Inventory Date'),
                TextColumn::make('assigned_to')
                    ->label('Assigned To'),
                TextColumn::make('counted_by')
                    ->label('Counted By'),
                TextColumn::make('ministry_id')
                    ->label('Ministry')
                    ->formatStateUsing(fn($state) => ucfirst(Ministry::find($state)->name)),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->slideOver()
                    ->modalWidth('md'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('md'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
