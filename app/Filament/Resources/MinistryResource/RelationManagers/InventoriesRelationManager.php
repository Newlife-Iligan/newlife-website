<?php

namespace App\Filament\Resources\MinistryResource\RelationManagers;

use App\Models\Ministry;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
            ]);
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
                TextColumn::make('ministry_id')
                    ->label('Ministry')
                    ->formatStateUsing(fn($state) => ucfirst(Ministry::find($state)->name)),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
