<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Actions\DownloadPDF;
use App\Filament\Resources\Actions\PrintForm;
use App\Filament\Resources\PurchaseApprovalRequestResource\Pages;
use App\Filament\Resources\PurchaseApprovalRequestResource\RelationManagers;
use App\Models\Members;
use App\Models\Ministry;
use App\Models\PurchaseApprovalRequest;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class PurchaseApprovalRequestResource extends Resource
{
    protected static ?string $model = PurchaseApprovalRequest::class;
    protected static ?string $navigationGroup = "Finance";

    protected static ?string $navigationLabel = "Purchase Approval Forms";

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->default(now())
                    ->required(),
                TextInput::make('type')
                    ->label('Event/Activity')
                    ->required(),
                TextInput::make('reason')
                    ->label('Reason')
                    ->required(),
                Select::make('head_id')
                    ->label('Dept Head Name')
                    ->searchable()
                    ->preload()
                    ->options(Members::all()->pluck('fullName','id')),
                Select::make('department_id')
                    ->label('Department')
                    ->searchable()
                    ->preload()
                    ->options(Ministry::all()->pluck('name','id')),
                Select::make('department_position')
                    ->label('Department Position')
                    ->required()
                    ->options([
                        "Head" => "Head",
                        "Member" => "Member",
                        "Head Assistant" => "Head Assistant",
                    ])
                    ->default('Head'),
                DatePicker::make('date_required')
                    ->label('The items need to be purchased on')
                    ->default(now())
                    ->required(),
                Repeater::make('items')
                    ->label('Items (Total Amount: ₱1.0)')
                    ->addActionLabel('Add Item')
                    ->schema([
                        TextInput::make('item_name')
                            ->label('Item Name')
                            ->required(),
                        TextInput::make('quantity')
                            ->numeric()
                            ->label('Quantity')
                            ->required(),
                        TextInput::make('unit_price')
                            ->label('Amount')
                            ->hintIcon("heroicon-o-question-mark-circle")
                            ->hintIconTooltip("Do not add comma to the amount. Instead of 1,500 put only 1500!")
                            ->required(),
                    ])
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['item_name'] ?? null)
                    ->cloneable()
                ->columns(3),
            ])

            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //TextColumn::make('date'),
                TextColumn::make('type')
                    ->words(4),
                TextColumn::make('reason')
                    ->words(5),
                TextColumn::make('total_amount')
                    ->badge()
                    ->money('PHP'),
                TextColumn::make('head_id')
                    ->formatStateUsing(fn($state) => Members::find($state)?->fullName),
                TextColumn::make('department_id')
                    ->formatStateUsing(fn($state) => Ministry::find($state)?->name),
                TextColumn::make('date_required')
                    ->date('M d, Y'),
            ])
            ->filters([
                SelectFilter::make('head_id')
                    ->label('Head')
                    ->multiple()
                    ->preload()
                    ->options(Members::all()->pluck('fullName','id')),
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->multiple()
                    ->preload()
                    ->options(Ministry::all()->pluck('name','id')),
            ])
            ->actions([
                PrintForm::make('purchase_approval'),
                DownloadPDF::make('purchase_approval'),
                Tables\Actions\EditAction::make()
                    ->after(function ($record) {
                    $items = $record->items;
                    $total = 0;
                    try {
                        foreach ($items as $item) {
                            $amount = $item["unit_price"];
                            $total += (float)$amount;
                        }
                        $rec = PurchaseApprovalRequest::find($record->id);
                        $rec->total_amount = $total;
                        $rec->save();
                    }catch (\Exception $exception){
                        Notification::make()
                            ->danger()
                            ->title('Total Amount Update Failed')
                            ->body($exception->getMessage())
                            ->send();
                    }

                }),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->visible(fn() => Auth::user()->isSuperAdmin())
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseApprovalRequests::route('/'),
//            'create' => Pages\CreatePurchaseApprovalRequest::route('/create'),
//            'edit' => Pages\EditPurchaseApprovalRequest::route('/{record}/edit'),
        ];
    }
}
