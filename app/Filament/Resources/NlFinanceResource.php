<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Actions\PrintForm;
use App\Filament\Resources\NlFinanceResource\Pages;
use App\Filament\Resources\NlFinanceResource\RelationManagers;
use App\Models\Members;
use App\Models\Ministry;
use App\Models\NlFinance;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NlFinanceResource extends Resource
{
    protected static ?string $model = NlFinance::class;
    protected static ?string $navigationGroup = "Finance";
    protected static ?string $navigationLabel = "NL Finance";
    protected static ?string $pluralLabel = "NL Finances";

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ToggleButtons::make('form_type')
                    ->options([
                        "cv_only" => "CV ONLY",
                        "ar_only" => "AR ONLY",
                        "cv_ar" => "CV & AR",
                    ])
                    ->default('cv_only')
                    ->inline()
                    ->reactive()
                    ->grouped(),
                Section::make("NewLife CV Form")
                    ->visible(function($get) {
                        $type = $get('form_type');

                        if($type == 'cv_only' || $type == 'cv_ar')
                        {
                            return 1;
                        }else{
                            return 0;
                        }
                    })
                    ->schema([
                        DatePicker::make('cv_date')
                            ->default(now())
                            ->columns(1)
                            ->label('Date'),
                        TextInput::make('cv_address')
                            ->columnSpan(2)
                            ->label('Address'),
                        TextInput::make('cv_particular')
                            ->columnSpan(3)
                            ->label('Particular'),
                        TextInput::make('cv_amount')
                            ->columnSpan(1)
                            ->prefix('₱')
                            ->label('Amount'),
                        ToggleButtons::make('mode_of_releasing')
                            ->options([
                                "cash" => "CASH",
                                "gcash" => "G-CASH",
                                "bpi" => "BPI",
                            ])
                            ->inline()
                            ->colors(function($state){
                                return [
                                    "cash" => "primary",
                                    "gcash" => Color::Blue,
                                    "bpi" => Color::Red,
                                ];
                            })
                            ->columnSpan(2)
                            ->grouped()
                            ->label('Mode of Releasing'),
                        TextInput::make('cv_amount_actual')
                            ->columnSpan(1)
                            ->prefix('₱')
                            ->label('Actual Amount'),
                        TextInput::make('cv_amount_returned')
                            ->columnSpan(1)
                            ->prefix('₱')
                            ->label('Returned Amount'),
                        ToggleButtons::make('mode_of_returning')
                            ->options([
                                "cash" => "CASH",
                                "gcash" => "G-CASH",
                                "bpi" => "BPI",
                            ])
                            ->inline()
                            ->colors(function($state){
                                return [
                                    "cash" => "primary",
                                    "gcash" => Color::Blue,
                                    "bpi" => Color::Red,
                                ];
                            })
                            ->columnSpan(1)
                            ->grouped()
                            ->label('Mode of Returning'),
                        Select::make('department')
                            ->searchable()
                            ->options(Ministry::all()->pluck('name','id')),
                        Select::make('cv_received_by')
                            ->label('Received By')
                            ->searchable()
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('cv_disbursed_by')
                            ->label('Disbursed By')
                            ->searchable()
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('cv_approved_by')
                            ->label('Approved By')
                            ->searchable()
                            ->options(Members::all()->pluck('fullName','id')),
                        ToggleButtons::make('cv_status')
                            ->options([
                                "liquidated" => "LIQUIDATED",
                                "incomplete_or" => "INCOMPLETE OR",
                                "lost_or" => "LOST OR",
                            ])
                            ->inline()
                            ->colors(function($state){
                                return [
                                    "liquidated" => Color::Green,
                                    "incomplete_or" => Color::Red,
                                    "lost_or" => Color::Gray,
                                ];
                            })
                            ->columnSpan(2)
                            ->grouped()
                            ->label('Status'),
                        TextInput::make('cv_or_number')
                            ->label('OR Number')
                    ])
                    ->columns(3),
                Section::make('NewLife AR Form')
                    ->schema([
                        TextInput::make('ar_number')
                            ->label('AR Number'),
                        TextInput::make('ar_amount_in_figures')
                            ->prefix('₱')
                            ->reactive()
                            ->debounce(1000)
                            ->afterStateUpdated(function($state,$set){
                                $set('ar_amount_in_words', self::numberToWords($state));
                            })
                            ->label('Amount in Figures'),
                        TextInput::make('ar_amount_in_words')
                            ->label('Amount in Words'),
                        DatePicker::make('ar_date')
                            ->label('Date'),
                        Select::make('ar_received_by')
                            ->searchable()
                            ->label('Received By')
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('ar_disbursed_by')
                            ->label('Disbursed By')
                            ->searchable()
                            ->options(Members::all()->pluck('fullName','id')),

                    ])
                    ->visible(function($get) {
                        $type = $get('form_type');

                        if($type == 'ar_only' || $type == 'cv_ar')
                        {
                            return 1;
                        }else{
                            return 0;
                        }
                    })
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cv_particular'),
                TextColumn::make('cv_address'),
            ])
            ->filters([
                //
            ])
            ->actions([
                PrintForm::make(),
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
            'index' => Pages\ListNlFinances::route('/'),
//            'create' => Pages\CreateNlFinance::route('/create'),
            'edit' => Pages\EditNlFinance::route('/{record}/edit'),
        ];
    }

    private static function  numberToWords($number)
    {
        $ones = [
            0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four',
            5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen',
            14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen',
            17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'
        ];

        $tens = [
            2 => 'twenty', 3 => 'thirty', 4 => 'forty', 5 => 'fifty',
            6 => 'sixty', 7 => 'seventy', 8 => 'eighty', 9 => 'ninety'
        ];

        $scales = [
            '', 'thousand', 'million', 'billion', 'trillion'
        ];

        if ($number === 0) {
            return 'zero';
        }

        if ($number < 0) {
            return 'negative ' . numberToWords(abs($number));
        }

        $words = [];
        $scaleIndex = 0;

        while ($number > 0) {
            $hundreds = $number % 1000;

            if ($hundreds != 0) {
                $group = [];

                // Handle hundreds
                if ($hundreds >= 100) {
                    $group[] = $ones[floor($hundreds / 100)] . ' hundred';
                    $hundreds = $hundreds % 100;
                }

                // Handle tens and ones
                if ($hundreds > 0) {
                    if ($hundreds < 20) {
                        $group[] = $ones[$hundreds];
                    } else {
                        $group[] = $tens[floor($hundreds / 10)];
                        if ($hundreds % 10 > 0) {
                            $group[] = $ones[$hundreds % 10];
                        }
                    }
                }

                // Add scale (thousand, million, etc.)
                if ($scaleIndex > 0) {
                    $group[] = $scales[$scaleIndex];
                }

                array_unshift($words, implode(' ', $group));
            }

            $number = floor($number / 1000);
            $scaleIndex++;
        }

        return implode(' ', $words);
    }

}
