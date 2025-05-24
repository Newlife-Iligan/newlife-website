<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RemindersResource\Pages;
use App\Filament\Resources\RemindersResource\RelationManagers;
use App\Models\Members;
use App\Models\Reminders;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RemindersResource extends Resource
{
    protected static ?string $model = Reminders::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->rows(6)
                    ->columnSpanFull(),
                Forms\Components\Select::make('member_id')
                    ->columnSpanFull()
                    ->options(Members::all()->pluck('full_name', 'id')),
                Forms\Components\ToggleButtons::make('specific_date')
                    ->inline()
                    ->default(false)
                    ->label('Specific Day Reminder?')
                    ->reactive()
                    ->grouped()
                    ->columnSpanFull()
                    ->boolean(),
                Forms\Components\DateTimePicker::make('date')
                    ->reactive()
                    ->hidden(fn($get)=> $get('specific_date') == false)
                    ->columnSpanFull(),
                Forms\Components\Select::make('week_number')
                    ->hidden(fn($get)=> $get('specific_date') == true)
                    ->reactive()
                    ->options([
                        1,2,3,4
                    ]),
                Forms\Components\Select::make('day_number')
                    ->reactive()
                    ->hidden(fn($get)=> $get('specific_date') == true)
                    ->options([
                        1 => "Monday",
                        2 => "Tuesday",
                        3 => "Wednesday",
                        4 => "Thursday",
                        5 => "Friday",
                        6 => "Saturday",
                        7 => "Sunday",
                    ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('member_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('week_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('xl'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReminders::route('/'),
//            'create' => Pages\CreateReminders::route('/create'),
//            'edit' => Pages\EditReminders::route('/{record}/edit'),
        ];
    }
}
