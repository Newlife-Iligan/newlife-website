<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditFormResource\Pages;
use App\Filament\Resources\AuditFormResource\RelationManagers;
use App\Models\AuditForm;
use App\Models\Members;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Vtiful\Kernel\Format;

class AuditFormResource extends Resource
{
    protected static ?string $model = AuditForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = "Finance";

    protected static ?int $navigationSort = 13;

    public static function canAccess(): bool
    {
        $is_finance = Auth::user()->canAccessAuditForms();
        if($is_finance)
            return true;
        else
            return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->default(now())
                    ->required(),
                TextInput::make('actual_amount'),
                TextInput::make('return_amount'),
                TextInput::make('refunded_amount'),
                Forms\Components\Section::make("OR / AR NUMBERS")
                    ->collapsible()
                    ->label("OR / AR NUMBERS")
                    ->schema([
                        Forms\Components\Repeater::make('or_ar_number')
                            ->label("")
                            ->schema([
                                TextInput::make('or_ar')
                                    ->label("OR / AR Number")
                                    ->required(),
                                TextInput::make('amount')
                                    ->numeric(),
                                DatePicker::make('date')
                                    ->default(now())
                                    ->label("Date")
                            ])
                            ->cloneable()
                            ->addActionLabel("ADD")
                            ->columns(3)
                            ->columnSpan(2)
                            ->required(),
                    ]),
                Forms\Components\Select::make('processed_by')
                    ->label("Processed By")
                    ->options(Members::all()->pluck('fullName', 'id')),
                Forms\Components\Select::make('audited_by')
                    ->label("Audited By")
                    ->options(Members::all()->pluck('fullName', 'id')),

                ToggleButtons::make('status')
                    ->options([
                        "liquidated" => "LIQUIDATED",
                        "on_going" => "ONGOING",
                        "incomplete_or" => "INC. OR",
                        "lost_or" => "LOST OR",
                    ])
                    ->inline()
                    ->colors(function($state){
                        return [
                            "liquidated" => Color::Green,
                            "incomplete_or" => Color::Red,
                            "lost_or" => Color::Gray,
                            "on_going" => Color::Yellow,
                        ];
                    })
                    ->grouped()
                    ->label('Status'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('actual_amount')
                    ->label('Actual')
                    ->money('PHP')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('return_amount')
                    ->label('Return')
                    ->money('PHP')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('refunded_amount')
                    ->money('PHP')
                    ->label('Refunded')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('or_ar_number')
                    ->label("OR / AR #")
                    ->limit(10)
                    ->tooltip(function ($record) {
                        $data = $record->or_ar_number;

                        if (empty($data)) {
                            return '-';
                        }

                        // Ensure it's an array
                        if (is_string($data)) {
                            $data = json_decode($data, true);
                        }

                        return collect($data)
                            ->pluck('or_ar')
                            ->filter()
                            ->implode(', ') ?: '-';
                    })
                    ->getStateUsing(function ($record) {
                        $data = $record->or_ar_number;

                        if (empty($data)) {
                            return '-';
                        }

                        // Ensure it's an array
                        if (is_string($data)) {
                            $data = json_decode($data, true);
                        }

                        return collect($data)
                            ->pluck('or_ar')
                            ->filter()
                            ->implode(', ') ?: '-';
                    }),
                Tables\Columns\TextColumn::make('processed_by')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Members::find($state)?->fullName)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('audited_by')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Members::find($state)?->fullName)
                    ->toggleable(),
                SelectColumn::make('status')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->label("Current - Status")
                    ->options([
                        "liquidated" => "LIQUIDATED",
                        "on_going" => "ONGOING",
                        "incomplete_or" => "INC. OR",
                        "lost_or" => "LOST OR",
                    ])

            ])
            ->filters([
                Filter::make('date')
                    ->form([
                        DatePicker::make('created_from')
                            ->label("Date From"),
                        DatePicker::make('created_until')
                            ->label("Date To"),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
                SelectFilter::make('processed_by')
                    ->multiple()
                    ->options(Members::all()->pluck('fullName', 'id')),
                SelectFilter::make('audited_by')
                    ->multiple()
                    ->options(Members::all()->pluck('fullName', 'id')),
                SelectFilter::make('status')
                    ->options([
                        "liquidated" => "LIQUIDATED",
                        "on_going" => "ONGOING",
                        "incomplete_or" => "INC. OR",
                        "lost_or" => "LOST OR",
                    ])
            ], layout: Tables\Enums\FiltersLayout::Modal)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
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
            'index' => Pages\ListAuditForms::route('/'),
//            'create' => Pages\CreateAuditForm::route('/create'),
//            'edit' => Pages\EditAuditForm::route('/{record}/edit'),
        ];
    }
}
