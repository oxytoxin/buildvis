<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatuses;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatusOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {

        $totalOrders = Order::query()->notInCart()->count();

        $pendingOrders = Order::query()->where('status', OrderStatuses::PENDING)->count();

        $processingOrders = Order::query()->where('status', OrderStatuses::PROCESSING)->count();

        $shippedOrders = Order::query()->where('status', OrderStatuses::SHIPPED)->count();

        $deliveredOrders = Order::query()->where('status', OrderStatuses::DELIVERED)->count();

        return [
            Stat::make('Total Orders', $totalOrders)
                ->description('All your orders')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),

            Stat::make('Pending', $pendingOrders)
                ->description('Awaiting processing')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Processing', $processingOrders)
                ->description('Being prepared')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('info'),

            Stat::make('Shipped', $shippedOrders)
                ->description('On the way')
                ->descriptionIcon('heroicon-m-truck')
                ->color('primary'),

            Stat::make('Delivered', $deliveredOrders)
                ->description('Successfully delivered')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
