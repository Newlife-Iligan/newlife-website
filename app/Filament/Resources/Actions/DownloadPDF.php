<?php

declare(strict_types=1);

namespace App\Filament\Resources\Actions;

use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;

class DownloadPDF extends Action
{
    const ACTION_NAME = 'downloadPDF';
    static protected $act_name = '';

    public static function make($name = self::ACTION_NAME): static
    {
        self::$act_name = $name;
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('PDF')
            ->tooltip('Download PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color(Color::Red)
            ->url(fn ($record): string => self::resolve_url() . $record->id)
            ->openUrlInNewTab();
    }

    private static function resolve_url()
    {
        if(self::$act_name == 'request_form')
        {
            return "/finance/download/";
        }else if(self::$act_name == 'purchase_approval')
        {
            return "/finance/download_approval/";
        }else
        {
            return "/finance/download/";
        }
    }
}

