<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class ProductStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $totalProducts = Product::count();
        $totalValue = Product::sum(\DB::raw('price * stock_quantity'));
        $lowStockCount = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', \DB::raw('minimum_stock_quantity'))
            ->count();
        $outOfStockCount = Product::where('stock_quantity', 0)->count();

        return [
            Stat::make('Total Products', $totalProducts)
                ->description('Total number of products')
                ->icon('heroicon-o-cube')
                ->color('primary'),

            Stat::make('Total Inventory Value', '₱' . Number::format($totalValue, 2))
                ->description('Value of all products in stock')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Low Stock Products', $lowStockCount)
                ->description('Products below minimum stock level')
                ->icon('heroicon-o-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'warning' : 'success'),

            Stat::make('Out of Stock Products', $outOfStockCount)
                ->description('Products with zero stock')
                ->icon('heroicon-o-x-circle')
                ->color($outOfStockCount > 0 ? 'danger' : 'success'),
        ];
    }
}
