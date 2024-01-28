<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Visit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Unique views', '192.1k')
                ->description('32k increase')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Bounce rate', '21%')
                ->description('7% increase'),
            Card::make('Average time on page', '3:12')
                ->description('3% increase'),
        ];
    }
}
