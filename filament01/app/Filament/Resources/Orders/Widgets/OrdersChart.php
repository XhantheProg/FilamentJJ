<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class OrdersChart extends ChartWidget
{
    protected ?string $heading = 'Ventas Mensuales';
    protected int|string|array $columnSpan = 2;

    // Altura del widget
    protected ?string $maxHeight = '320px';


    protected function getData(): array
    {
        $now = Carbon::now();

        $yearCurrent = $now->year; // 2026
        $monthCurrent = $now->month; // enero
        $startCurrent = $now->copy()->startOfMonth(); // Primer dia del mes
        $daysInCurrent = $startCurrent->daysInMonth();

        $prev = $now->copy()->subMonth(); // Mes anterior
        $monthPrev = $prev->month; // numero del mes anterior
        $startPrev = $prev->copy()->startOfMonth();
        $dayInPrev = $startPrev->daysInMonth();

        // Postgres
        $totalsCurrent = Order::selectRaw('EXTRACT(DAY FROM created_at) as day, SUM(total) as total')
            ->whereYear('created_at', $yearCurrent)
            ->whereMonth('created_at', $monthCurrent)
            ->groupByRaw('EXTRACT(DAY FROM created_at)')
            ->pluck('total', 'day');
        $totalsPrev = Order::selectRaw('EXTRACT(DAY FROM created_at) as day, SUM(total) as total')
            ->whereYear('created_at', $yearCurrent)
            ->whereMonth('created_at', $monthPrev)
            ->groupByRaw('EXTRACT(DAY FROM created_at)')
            ->pluck('total', 'day');

        // MySQL
        // $totalsCurrent = Order::selectRaw('DAY(created_at) as day, SUM(total) as total')
        //     ->whereYear('created_at', $yearCurrent)
        //     ->whereMonth('created_at', $monthCurrent)
        //     ->groupByRaw('DAY(created_at)')
        //     ->pluck('total', 'day');


        // $totalsPrev = Order::selectRaw('DAY(created_at) as day, SUM(total) as total')
        //     ->whereYear('created_at', $yearCurrent)
        //     ->whereMonth('created_at', $monthPrev)
        //     ->groupByRaw('DAY(created_at)')
        //     ->pluck('total', 'day');

        $labels = [];
        $dataCurrent = [];
        $dataPrev = [];

        for ($day = 1; $day <= $daysInCurrent; $day++) {

            $labels[] = sprintf('%02d/%02d', $day, $monthCurrent);

            $dataCurrent[] = isset($totalsCurrent[$day]) ? (float) $totalsCurrent[$day] : 0;

            if ($day <= $dayInPrev) {
                $dataPrev[] = isset($totalsPrev[$day]) ? (float)$totalsPrev[$day] : 0;
            } else {
                $dataPrev[] = 0;
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Mes actual',
                    'data' => $dataCurrent,
                    'tension' => 0.3,
                    'borderColor' => '#4caf50',
                ],
                [
                    'label' => 'Mes anterior',
                    'data' => $dataPrev,
                    'tension' => 0.3,
                    'borderColor' => '#2062b3',
                ]
            ]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getHeading(): string|Htmlable|null
    {
        return 'Ventas mensuales';
    }

    public function getDescription(): string|Htmlable|null
    {
        return 'Comparativa de ventas del mes actual y el mes anterior';
    }
}
