<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Actions\CreateAccount;
use App\Filament\Resources\MembersResource\Pages;
use App\Filament\Resources\MembersResource\RelationManagers;
use App\Models\LifeGroup;
use App\Models\MemberRole;
use App\Models\Members;
use App\Models\Ministry;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MembersResource extends Resource
{
    protected static ?string $model = Members::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('profile_pic')
                    ->disk('public')
                    ->image()
                    ->optimize('webp')
                    ->directory('profile_pic'),
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('nickname'),
                Select::make('role')
                    ->relationship('roles','name'),
                DatePicker::make('birthday'),
                TextInput::make('address')
                    ->prefixIcon('heroicon-o-home'),
                TextInput::make('contact_number')
                    ->placeholder('09xxxxxxxxx')
                    ->rules(['digits:11', 'starts_with:09'])
                    ->prefixIcon('heroicon-o-phone'),
                TextInput::make('email')
                    ->placeholder('member@newlife.com')
                    ->email()
                    ->prefixIcon('heroicon-o-envelope'),
                TextInput::make('facebook_url')
                    ->placeholder('www.facebook.com/newlife-iligan')
                    ->prefixIcon('heroicon-o-link'),
                Select::make('ministry_id')
                    ->options(Ministry::all()->pluck('name','id'))
                    ->label('Ministry'),
                Select::make('life_group_id')
                    ->options(LifeGroup::all()->pluck('name', 'id'))
                    ->label('LifeGroup'),
                Textarea::make('motto'),
                TextInput::make('life_verse'),
                Textarea::make('bible_verse'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                ImageColumn::make('profile_pic')
                    ->rounded()
                    ->alignCenter(),
                TextColumn::make('first_name')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('last_name')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('nickname')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(Color::Gray)
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => strtoupper($state)),
                TextColumn::make('role')
                    ->badge()
//                    ->color(fn ($state): string => match ($state) {
//                        1 => 'gray',
//                        2 => 'warning',
//                        3 => 'success',
//                        4 => 'danger',
//                        5 => 'info',
//                        6 => 'primary',
//                        7 => 'secondary',
//                        8 => 'secondary-dark',
//                        9 => 'primary-dark',
//                    })
                    ->color(fn($state)=> Color::rgb(MemberRole::find($state)->color ?? "rgb(192,192,192)"))
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->formatStateUsing(fn($state)=> MemberRole::find($state)->name),
                TextColumn::make('birthday')
                    ->label('Age')
                    ->alignCenter()
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state)=>Carbon::make($state)->age . ' yrs old'),
                TextColumn::make('ministry_id')
                    ->label('Ministry')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => ucfirst(Ministry::find($state)->name)),
                TextColumn::make('life_group_id')
                    ->label('Life Group')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => ucfirst(LifeGroup::find($state)->name)),
                TextColumn::make('life_verse')
                    ->label('Life Verse')
                    ->searchable()
                    ->words(5)
                    ->tooltip(fn($record) => $record->bible_verse)
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ministry_id')
                    ->multiple()
                    ->options(Ministry::all()->pluck('name','id')),
                Tables\Filters\SelectFilter::make('life_group_id')
                    ->multiple()
                    ->options(LifeGroup::all()->pluck('name','id')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->slideOver()
                        ->modalWidth('md'),
                    CreateAccount::make(),
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->hidden(!Auth::user()->isSuperAdmin()),
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
            'index' => Pages\ListMembers::route('/'),
//            'create' => Pages\CreateMembers::route('/create'),
//            'edit' => Pages\EditMembers::route('/{record}/edit'),
        ];
    }

}
