<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Customers\Widgets\CustomersOverview;
use App\Filament\Resources\Orders\Widgets\OrdersOverview;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            ProductsOverview::getProductsOverviewStat(),
            OrdersOverview::getOrderOverviewStat(),
            CustomersOverview::getCustomersOverviewStat(),
        ];
    }
}
