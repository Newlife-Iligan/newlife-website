<?php

declare(strict_types=1);

namespace App\Filament\Resources\Actions;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\View;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;

class CreateAccount extends Action
{
    const ACTION_NAME = 'createAccount';

    public static function make($name = self::ACTION_NAME): static
    {
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Create Account')
            //->tooltip('Create an account for this member.')
            ->icon('heroicon-o-user-plus')
            ->form([
                TextInput::make('name')
                    ->default(fn($record) => $record->fullName)
                    ->readonly(),
                TextInput::make('email')
                    ->required()
                    ->default(fn($record) => $record->email)
                    ->readonly(),
                TextInput::make('password')
                    ->password(function(Callable $get){
                        return !$get('show_password');
                    })
                    ->reactive()
                    ->default('newlife.2025'),
                ToggleButtons::make('show_password')
                    ->label('Show Password')
                    ->reactive()
                    ->default(false)
                    ->boolean()
                    ->inline()
                    ->grouped(),


            ])
            ->slideOver()
            ->modalWidth('md')
            ->action(function($record){
                try{
                    $data = $this->formData;
                    $member_id = $record->id;

                    $new_user = new User();
                    $new_user->name = $data['name'];
                    $new_user->email = $data['email'];
                    $new_user->member_id = $member_id;
                    $new_user->password = $data['password'];
                    $new_user->save();
                    Notification::make('success')
                        ->title('Account created')
                        ->body("{$new_user->name} account has been created. He/She can now login with the new account.")
                        ->success()
                        ->send();
                }
                catch (\Exception $exception){
                    Notification::make('failure')
                        ->title('Account failed to create')
                        ->body("{$new_user->name} account failed to create. Reason: {$exception->getMessage()}")
                        ->danger()
                        ->send();
                }
            })
            ->hidden(fn($record) => $record->user)
            ->color(Color::Teal);
    }
}

