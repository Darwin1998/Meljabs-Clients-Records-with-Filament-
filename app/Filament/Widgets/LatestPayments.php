<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestPayments extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Payment::with('client')->latest()->take(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('client.full_name')->label('Name'),
            TextColumn::make('amount')->formatStateUsing(fn (string $state): string => __('₱' . $state)),
            TextColumn::make('date')->date('F j, Y'),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
