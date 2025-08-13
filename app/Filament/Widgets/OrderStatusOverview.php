<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class OrderStatusOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = Auth::id();

        $totalOrders = Order::query()->notInCart()->whereHas('customer', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        $pendingOrders = Order::query()->notInCart()->whereHas('customer', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'pending')->count();

        $processingOrders = Order::query()->notInCart()->whereHas('customer', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'processing')->count();

        $shippedOrders = Order::query()->notInCart()->whereHas('customer', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'shipped')->count();

        $deliveredOrders = Order::query()->notInCart()->whereHas('customer', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'delivered')->count();

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
