<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('total_price');
        $ordersToday = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        return [
            Stat::make('Total Sales', '$' . number_format($totalSales, 2))
                ->description('Overall lifetime sales')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Orders Today', $ordersToday)
                ->description('New orders placed today')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
                
            Stat::make('Pending Orders', $pendingOrders)
                ->description('Orders awaiting processing')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingOrders > 10 ? 'warning' : 'primary'),
        ];
    }
}