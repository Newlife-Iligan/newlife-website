<?php

declare(strict_types=1);

namespace App\Filament\Resources\Actions;

use App\Models\Candidate;
use Filament\Tables\Actions\Action;

class PrintForm extends Action
{
    const ACTION_NAME = 'printForm';

    public static function make($name = self::ACTION_NAME): static
    {
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Print')
            ->tooltip('Print Form')
            ->icon('heroicon-o-printer')
            ->color('success')
            ->url(fn ($record): string => "/finance/print/" . $record->id)
            ->openUrlInNewTab();
    }
}

