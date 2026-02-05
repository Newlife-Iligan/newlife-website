<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainRawFileResource\Pages;
use App\Filament\Resources\MainRawFileResource\RelationManagers;
use App\Models\MainRawFile;
use App\Models\Members;
use App\Models\Ministry;
use App\Models\NlAccount;
use App\Models\NlFinance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MainRawFileResource extends Resource
{
    protected static ?string $model = NlFinance::class;
    protected static ?string $navigationGroup = "Finance";
    protected static ?string $label = "Main File";
    protected static ?int $navigationSort = 14;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function canAccess(): bool
    {
        $is_finance = Auth::user()->isFinance();
        if($is_finance)
            return true;
        else
            return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form_type')
                    ->toggleable()
                    ->searchable()
                    ->formatStateUsing(function($state){
                        if($state == "cv_only")
                        {
                            return "CV ONLY";
                        }else if($state == "ar_only")
                        {
                            return "AR ONLY";
                        }else if($state == "cv_ar")
                        {
                            return "CV & AR";
                        }else if($state == "ch_ar")
                        {
                            return "CH & AR";
                        }else if($state == "ch_only")
                        {
                            return "CH ONLY";
                        }
                        return null;
                    }),
                TextColumn::make('type')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('cv_number')
                    ->label('CV No.')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('cv_date')
                    ->label('CV Date')
                    ->date()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('cv_address')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                TextColumn::make('cv_particular')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('cv_amount')
                    ->label('CV Amount')
                    ->money('PHP')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('mode_of_releasing')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('cv_amount_actual')
                    ->label('Actual Amt')
                    ->money('PHP')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('cv_amount_returned')
                    ->label('Returned Amt')
                    ->money('PHP')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('mode_of_returning')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('department')
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Ministry::find($state)?->name)
                    ->toggledHiddenByDefault(),
                TextColumn::make('cv_received_by')
                    ->label('CV Received By')
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Members::find($state)?->fullName)
                    ->toggledHiddenByDefault(),
                TextColumn::make('cv_disbursed_by')
                    ->label('CV Disbursed By')
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Members::find($state)?->fullName)
                    ->toggledHiddenByDefault(),
                TextColumn::make('cv_approved_by')
                    ->label('CV Approved By')
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Members::find($state)?->fullName)
                    ->toggledHiddenByDefault(),
                TextColumn::make('cv_status')
                    ->label('CV Status')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('cv_or_number')
                    ->label('CV OR No.')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                TextColumn::make('chv_number')
                    ->label('CHV No.')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                TextColumn::make('ar_number')
                    ->label('AR No.')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('ar_particular')
                    ->label('AR Particular')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                TextColumn::make('ar_amount_in_words')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('ar_amount_in_figures')
                    ->label('AR Amount')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('ar_date')
                    ->label('AR Date')
                    ->date()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                TextColumn::make('ar_received_by')
                    ->label('AR Received By')
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Members::find($state)?->fullName)
                    ->toggledHiddenByDefault(),
                TextColumn::make('ar_disbursed_by')
                    ->label('AR Disbursed By')
                    ->toggleable()
                    ->formatStateUsing(fn($state) => Members::find($state)?->fullName)
                    ->toggledHiddenByDefault(),
                TextColumn::make('releasing_ref_number')
                    ->label('Releasing Ref No.')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                TextColumn::make('returned_amt_receiver')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('return_ref_number')
                    ->label('Return Ref No.')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                TextColumn::make('check_number')
                    ->label('Check No.')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                TextColumn::make('account_id')
                    ->label('Account')
                    ->toggleable()
                    ->formatStateUsing(fn($state) => NlAccount::find($state)?->name)
                    ->toggledHiddenByDefault(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMainRawFiles::route('/'),
//            'create' => Pages\CreateMainRawFile::route('/create'),
//            'edit' => Pages\EditMainRawFile::route('/{record}/edit'),
        ];
    }
}
