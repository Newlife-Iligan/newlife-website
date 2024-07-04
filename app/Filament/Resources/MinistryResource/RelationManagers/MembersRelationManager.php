<?php

namespace App\Filament\Resources\MinistryResource\RelationManagers;

use App\Models\LifeGroup;
use App\Models\Ministry;
use App\Models\MemberRole;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                ImageColumn::make('profile_pic')
                    ->rounded()
                    ->alignCenter(),
                TextColumn::make('first_name')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('last_name')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('nickname')
                    ->badge()
                    ->color(Color::Gray)
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => strtoupper($state)),
                TextColumn::make('role')
                    ->badge()
                    ->alignCenter()
                    ->formatStateUsing(fn($state)=> MemberRole::find($state)->name),
                TextColumn::make('birthday')
                    ->label('Age')
                    ->alignCenter()
                    ->formatStateUsing(fn($state)=>Carbon::make($state)->age . ' yrs old'),
//                TextColumn::make('ministry_id')
//                    ->label('Ministry')
//                    ->formatStateUsing(fn($state) => ucfirst(Ministry::find($state)->name)),
                TextColumn::make('life_group_id')
                    ->label('Life Group')
                    ->formatStateUsing(fn($state) => ucfirst(LifeGroup::find($state)->name)),
                TextColumn::make('life_verse')
                    ->label('Life Verse')
                    ->words(5)
                    ->tooltip(fn($record) => $record->bible_verse)
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
