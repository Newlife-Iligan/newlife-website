<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Actions\DownloadPDF;
use App\Filament\Resources\Actions\PrintForm;
use App\Filament\Resources\NlFinanceResource\Pages;
use App\Filament\Resources\NlFinanceResource\RelationManagers;
use App\Models\Members;
use App\Models\Ministry;
use App\Models\NlAccount;
use App\Models\NlFinance;
use Database\Seeders\NLAccountSeeder;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class NlFinanceResource extends Resource
{
    protected static ?string $model = NlFinance::class;
    protected static ?string $navigationGroup = "Finance";
    protected static ?string $label = "Request Form";

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

        public static function form(Form $form): Form
    {
        $is_finance = Auth::user()->isFinance() || Auth::user()->isSuperAdmin();

        return $form
            ->schema([
                ToggleButtons::make('form_type')
                    ->options([
                        "cv_only" => "CashV",
                        "ch_only" => "CheckV",
                        "ar_only" => "AR",
                        "cv_ar" => "CV & AR",
                        "ch_ar" => "CH & AR",
                    ])
                    ->default('cv_only')
                    ->inline()
                    ->reactive()
                    ->grouped(),
                Section::make("NewLife Cash Voucher Form")
                    ->collapsible()
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
                        Select::make('type')
                            ->options([
                                "Activity" => "Activity",
                                "Event" => "Event",
                            ])
                            ->label('Type'),
                        DatePicker::make('cv_date')
                            ->default(now())
                            ->required()
                            ->label('Date'),
                        TextInput::make('cv_address')
                            ->label('Address'),
                        TextInput::make('cv_particular')
                            ->required()
                            ->label('Particular/Purpose'),
                        TextInput::make('cv_amount')
                            ->prefix('₱')
                            ->label('Amount'),
                        Select::make('returned_amt_receiver')
                            ->label('Returned Amount Receiver')
                            ->searchable()
                            ->hidden(!$is_finance)
                            ->options(Members::all()->pluck('fullName','id')),
                        TextInput::make('return_ref_number')
                            ->hidden(!$is_finance)
                            ->label('Reference / Confirmation #'),
                        Select::make('department')
                            ->searchable()
                            ->options(Ministry::all()->pluck('name','id')),
                        Select::make('cv_received_by')
                            ->label('Received By')
                            ->searchable()
                            ->required()
                            ->default(Auth::user()->member_id)
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('cv_disbursed_by')
                            ->label('Disbursed By')
                            ->searchable()
                            ->required()
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('cv_approved_by')
                            ->label('Approved By')
                            ->searchable()
                            ->required()
                            ->options(Members::all()->pluck('fullName','id')),

                        Section::make('Finance Staff Fields')
                            ->description("Fields below are for Finance Staff to fill-in. Only Finance Staff can see these fields.")
                            ->collapsible()
                            ->hidden(!$is_finance)
                            ->heading('Staff Fields')
                            ->schema([
                                ToggleButtons::make('mode_of_releasing')
                                    ->options([
                                        "cash" => "CASH",
                                        "gcash" => "G-CASH",
                                        "bpi" => "BPI",
                                    ])
                                    ->hidden(!$is_finance)
                                    ->inline()
                                    ->colors(function($state){
                                        return [
                                            "cash" => "primary",
                                            "gcash" => Color::Blue,
                                            "bpi" => Color::Red,
                                        ];
                                    })
                                    ->grouped()
                                    ->label('Mode of Releasing'),
                                TextInput::make('releasing_ref_number')
                                    ->hidden(!$is_finance)
                                    ->label('Reference / Confirmation #'),
                                TextInput::make('cv_amount_actual')
                                    ->prefix('₱')
                                    ->hidden(!$is_finance)
                                    ->label('Actual Amount'),
                                TextInput::make('cv_amount_returned')
                                    ->prefix('₱')
                                    ->hidden(!$is_finance)
                                    ->label('Returned Amount'),
                                ToggleButtons::make('mode_of_returning')
                                    ->options([
                                        "cash" => "CASH",
                                        "gcash" => "G-CASH",
                                        "bpi" => "BPI",
                                    ])
                                    ->inline()
                                    ->hidden(!$is_finance)
                                    ->colors(function($state){
                                        return [
                                            "cash" => "primary",
                                            "gcash" => Color::Blue,
                                            "bpi" => Color::Red,
                                        ];
                                    })
                                    ->grouped()
                                    ->label('Mode of Returning'),
                                ToggleButtons::make('cv_status')
                                    ->options([
                                        "liquidated" => "LIQUIDATED",
                                        "incomplete_or" => "INC. OR",
                                        "lost_or" => "LOST OR",
                                    ])
                                    ->inline()
                                    ->hidden(!$is_finance)
                                    ->colors(function($state){
                                        return [
                                            "liquidated" => Color::Green,
                                            "incomplete_or" => Color::Red,
                                            "lost_or" => Color::Gray,
                                        ];
                                    })
                                    ->grouped()
                                    ->label('Status'),
                                TextInput::make('cv_or_number')
                                    ->hidden(!$is_finance)
                                    ->label('OR Number'),
                                Select::make('account_id')
                                    ->label('Account')
                                    ->hidden(!$is_finance)
                                    ->searchable()
                                    ->options(NlAccount::all()->pluck('name','id')),
                            ])

                    ])
                    ->columns(1),
                Section::make("NewLife Check Voucher Form")
                    ->collapsible()
                    ->visible(function($get) {
                        $type = $get('form_type');

                        if($type == 'ch_only' || $type == 'ch_ar')
                        {
                            return 1;
                        }else{
                            return 0;
                        }
                    })
                    ->schema([
                        Select::make('type')
                            ->options([
                                "Activity" => "Activity",
                                "Event" => "Event",
                            ])
                            ->label('Type'),
                        TextInput::make('check_number')
                            ->label('Check Number'),
                        TextInput::make('chv_number')
                            ->label('Check Voucher Number'),
                        DatePicker::make('cv_date')
                            ->default(now())
                            ->required()
                            ->label('Date'),
                        TextInput::make('cv_address')
                            ->label('Address'),
                        TextInput::make('cv_particular')
                            ->required()
                            ->label('Particular/Purpose'),
                        TextInput::make('cv_amount')
                            ->prefix('₱')
                            ->label('Amount'),
                        Select::make('returned_amt_receiver')
                            ->label('Returned Amount Receiver')
                            ->searchable()
                            ->hidden(!$is_finance)
                            ->options(Members::all()->pluck('fullName','id')),
                        TextInput::make('return_ref_number')
                            ->hidden(!$is_finance)
                            ->label('Reference / Confirmation #'),
                        Select::make('department')
                            ->searchable()
                            ->options(Ministry::all()->pluck('name','id')),
                        Select::make('cv_received_by')
                            ->label('Received By')
                            ->searchable()
                            ->default(Auth::user()->member_id)
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('cv_disbursed_by')
                            ->label('Disbursed By')
                            ->searchable()
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('cv_approved_by')
                            ->label('Approved By')
                            ->searchable()
                            ->options(Members::all()->pluck('fullName','id')),

                        Section::make('Finance Staff Fields')
                            ->description("Fields below are for Finance Staff to fill-in. Only Finance Staff can see these fields.")
                            ->collapsible()
                            ->hidden(!$is_finance)
                            ->heading('Staff Fields')
                            ->schema([
                                ToggleButtons::make('mode_of_releasing')
                                    ->options([
                                        "cash" => "CASH",
                                        "gcash" => "G-CASH",
                                        "bpi" => "BPI",
                                    ])
                                    ->hidden(!$is_finance)
                                    ->inline()
                                    ->colors(function($state){
                                        return [
                                            "cash" => "primary",
                                            "gcash" => Color::Blue,
                                            "bpi" => Color::Red,
                                        ];
                                    })
                                    ->grouped()
                                    ->label('Mode of Releasing'),
                                TextInput::make('releasing_ref_number')
                                    ->hidden(!$is_finance)
                                    ->label('Reference / Confirmation #'),
                                TextInput::make('cv_amount_actual')
                                    ->prefix('₱')
                                    ->hidden(!$is_finance)
                                    ->label('Actual Amount'),
                                TextInput::make('cv_amount_returned')
                                    ->prefix('₱')
                                    ->hidden(!$is_finance)
                                    ->label('Returned Amount'),
                                ToggleButtons::make('mode_of_returning')
                                    ->options([
                                        "cash" => "CASH",
                                        "gcash" => "G-CASH",
                                        "bpi" => "BPI",
                                    ])
                                    ->inline()
                                    ->hidden(!$is_finance)
                                    ->colors(function($state){
                                        return [
                                            "cash" => "primary",
                                            "gcash" => Color::Blue,
                                            "bpi" => Color::Red,
                                        ];
                                    })
                                    ->grouped()
                                    ->label('Mode of Returning'),
                                ToggleButtons::make('cv_status')
                                    ->options([
                                        "liquidated" => "LIQUIDATED",
                                        "incomplete_or" => "INC. OR",
                                        "lost_or" => "LOST OR",
                                    ])
                                    ->inline()
                                    ->hidden(!$is_finance)
                                    ->colors(function($state){
                                        return [
                                            "liquidated" => Color::Green,
                                            "incomplete_or" => Color::Red,
                                            "lost_or" => Color::Gray,
                                        ];
                                    })
                                    ->grouped()
                                    ->label('Status'),
                                TextInput::make('cv_or_number')
                                    ->hidden(!$is_finance)
                                    ->label('OR Number'),
                                Select::make('account_id')
                                    ->label('Account')
                                    ->hidden(!$is_finance)
                                    ->searchable()
                                    ->options(NlAccount::all()->pluck('name','id')),
                            ])
                    ])
                    ->columns(1),
                Section::make('NewLife AR Form')
                    ->collapsible()
                    ->schema([
                        TextInput::make('ar_particular')
                            ->required()
                            ->label('AR Particular'),
                        TextInput::make('ar_number')
                            ->label('AR Number'),
                        TextInput::make('ar_amount_in_figures')
                            ->prefix('₱')
                            ->reactive()
                            ->debounce(1000)
                            ->afterStateUpdated(function($state,$set){
                                $set('ar_amount_in_words', self::numberToWords($state) . " pesos");
                            })
                            ->label('Amount in Figures'),
                        TextInput::make('ar_amount_in_words')
                            ->label('Amount in Words'),
                        DatePicker::make('ar_date')
                            ->label('Date'),
                        Select::make('ar_received_by')
                            ->searchable()
                            ->label('Received By')
                            ->default(Auth::user()->member_id)
                            ->options(Members::all()->pluck('fullName','id')),
                        Select::make('ar_disbursed_by')
                            ->label('Disbursed By')
                            ->searchable()
                            ->options(Members::all()->pluck('fullName','id')),

                    ])
                    ->visible(function($get) {
                        $type = $get('form_type');

                        if($type == 'ar_only' || $type == 'cv_ar' || $type == 'ch_ar')
                        {
                            return 1;
                        }else{
                            return 0;
                        }
                    })
                    ->columns(1)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        $is_finance = Auth::user()->isFinance();
        return $table
            ->columns([
                TextColumn::make('form_type')
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
                    })
                    ->sortable(),
                TextColumn::make('cv_particular')
                    ->sortable()
                    ->default(1)
                    ->formatStateUsing(function($record){
                        if(!empty($record->cv_particular))
                        {
                            return $record->cv_particular;
                        }else if(!empty($record->ar_particular))
                        {
                            return $record->ar_particular;
                        }
                        else{
                            return "N/A";
                        }
                    })
                    ->label('Particular'),
                TextColumn::make('cv_received_by')
                    ->label('Received By')
                    ->default(1)
                    ->sortable()
                    ->formatStateUsing(function($record){
                        if(!empty($record->cv_received_by))
                        {
                            return Members::find($record->cv_received_by)->fullName;
                        }else if(!empty($record->ar_received_by))
                        {
                            return Members::find($record->ar_received_by)->fullName;
                        }
                        else{
                            return "N/A";
                        }
                    }),
                TextColumn::make('created_at')
                    ->date('M d, Y')
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                PrintForm::make(),
                DownloadPDF::make(),
                Tables\Actions\EditAction::make()
                    ->modalHeading('NewLife Finance Form'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->visible(fn() => Auth::user()->isSuperAdmin())
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
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
//            'edit' => Pages\EditNlFinance::route('/{record}/edit'),
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

    private static function formSchema($form_type): array
    {
        switch ($form_type) {
            case "cv_only":
                return [];
        }
        return [];
    }

}
