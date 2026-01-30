<?php

declare(strict_types=1);

namespace App\Filament\Resources\Actions;

use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;

class DownloadPDF extends Action
{
    const ACTION_NAME = 'downloadPDF';

    public static function make($name = self::ACTION_NAME): static
    {
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('PDF')
            ->tooltip('Download PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color(Color::Red)
            ->url(fn ($record): string => "/finance/download/" . $record->id)
            ->openUrlInNewTab();
    }
}

