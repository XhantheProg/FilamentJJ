<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrdersOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            static::getOrderOverviewStat()
        ];
    }

    public static function getOrderOverviewStat()
    {
        $actualStart = now()->startOfMonth(); // 2026-01-01
        $actualEnd = now()->endOfMonth(); // 2026-01-31

        $beforeStart = now()->subMonth()->startOfMonth();
        $beforeEnd = now()->subMonth()->endOfMonth();

        $newOrders = Order::whereBetween('created_at', [$actualStart, $actualEnd])->count();
        $beforeOrders = Order::whereBetween('created_at', [$beforeStart, $beforeEnd])->count();

        $status = $newOrders >= $beforeOrders;

        $color = $status ? 'success' : 'danger';

        $trending = $status ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down';

        return
            Stat::make('Nuevas órdenes', $newOrders)
                ->description($newOrders - $beforeOrders . ' en el último mes')
                ->descriptionIcon($trending)
                ->color($color)
                ->chart([$beforeOrders, $newOrders]);

    }
}