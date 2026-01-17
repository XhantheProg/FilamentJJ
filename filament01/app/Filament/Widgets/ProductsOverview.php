<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            static::getProductsOverviewStat()
        ];
    }

    public static function getProductsOverviewStat()
    {
        $product = Product::count();
        

        return Stat::make('Productos', $product)
            ->description('Productos registrados')
            ->descriptionIcon('heroicon-o-arrow-trending-up')
            ->color('primary')
            ->chart([10,20,30,25,40,45,80]);
    }
}