<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembersResource\Pages;
use App\Filament\Resources\MembersResource\RelationManagers;
use App\Models\LifeGroup;
use App\Models\Members;
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
                    ->relationship('role'),
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
                    ->options([])
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
                    ->default('MEMBER'),
                TextColumn::make('birthday')
                    ->label('Age')
                    ->alignCenter()
                    ->formatStateUsing(fn($state)=>Carbon::make($state)->age . ' yrs old'),
                TextColumn::make('ministry_id')
                    ->label('Ministry'),
                TextColumn::make('life_group_id')
                    ->label('Life Group')
                    ->formatStateUsing(fn($state) => ucfirst(LifeGroup::find($state)->name)),
                TextColumn::make('life_verse')
                    ->label('Life Verse')
                    ->tooltip(fn($record) => $record->bible_verse)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('md'),
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
            'index' => Pages\ListMembers::route('/'),
//            'create' => Pages\CreateMembers::route('/create'),
//            'edit' => Pages\EditMembers::route('/{record}/edit'),
        ];
    }

}
