<?php

namespace App\Filament\Widgets;

use App\Models\Barangay;
use App\Models\Client;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getCards(): array
    {
        return [
            Card::make('Total Clients ', Client::getModel()::count()),
            Card::make('Total Barangays ', Barangay::getModel()::count()),
            Card::make('Total income from installation ', '₱' . Client::sum('amount')),

            Card::make('Total Income this month', '₱' . Payment::where('created_at', '>', now()->subDays(30))->sum('amount')),
            Card::make('Over all income from clients payments', '₱' . Payment::sum('amount')),
        ];
    }
}
