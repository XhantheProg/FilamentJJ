<?php

namespace App\Filament\Resources\Customers\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomersOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            static::getCustomersOverviewStat()
        ];
    }

    public static function getCustomersOverviewStat(){
        $actualStart = now()->startOfMonth(); // 2026-01-01
        $actualEnd = now()->endOfMonth(); // 2026-01-31

        $beforeStart = now()->subMonth()->startOfMonth();
        $beforeEnd = now()->subMonth()->endOfMonth();

        $newCustomers = Customer::whereBetween('created_at', [$actualStart, $actualEnd])->count();
        $beforeCustomers = Customer::whereBetween('created_at', [$beforeStart, $beforeEnd])->count();

        $status = $newCustomers >= $beforeCustomers;

        $color = $status ? 'success' : 'danger';

        $trending = $status ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down';

        return
            Stat::make('Nuevas Clientes', $newCustomers)
                ->description($newCustomers - $beforeCustomers . ' en el último mes')
                ->descriptionIcon($trending)
                ->color($color)
                ->chart([$beforeCustomers, $newCustomers]);
    }
}
