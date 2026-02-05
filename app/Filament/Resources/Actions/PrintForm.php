<?php

declare(strict_types=1);

namespace App\Filament\Resources\Actions;

use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;

class PrintForm extends Action
{
    const ACTION_NAME = 'printForm';
    static protected $act_name = '';

    public static function make($name = self::ACTION_NAME): static
    {
        self::$act_name = $name;
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Print')
            ->tooltip('Print Form')
            ->icon('heroicon-o-printer')
            ->color(Color::Blue)
            ->url(fn ($record): string => self::resolve_url() . $record->id)
            ->openUrlInNewTab();
    }

    private static function resolve_url()
    {
        if(self::$act_name == 'request_form')
        {
            return "/finance/print/";
        }else if(self::$act_name == 'purchase_approval')
        {
            return "/finance/print_approval/";
        }else
        {
            return "/finance/print/";
        }
    }
}

