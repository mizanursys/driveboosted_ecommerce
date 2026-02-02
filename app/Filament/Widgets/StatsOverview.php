<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return \Cache::remember('filament.stats.overview', 600, function () {
            $totalOrders = Order::count();
            $pendingOrders = Order::where('status', 'pending')->count();
            $totalRevenue = Order::where('status', 'completed')->sum('total');
            
            // Optimized query for cost calculation
            $totalCost = \DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.status', 'completed')
                ->sum(\DB::raw('order_items.cost_price * order_items.quantity'));

            $totalExpenses = \App\Models\Expense::sum('amount');
            $totalProfit = $totalRevenue - $totalCost - $totalExpenses;
            $totalProducts = Product::count();
            
            return [
                Stat::make('Total Revenue', '৳' . number_format($totalRevenue))
                    ->description('From completed orders')
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->color('success'),

                Stat::make('Net Profit', '৳' . number_format($totalProfit))
                    ->description('Revenue - Cost - Expense')
                    ->descriptionIcon('heroicon-m-presentation-chart-line')
                    ->color($totalProfit >= 0 ? 'success' : 'danger'),

                Stat::make('Total Expenses', '৳' . number_format($totalExpenses))
                    ->description('Shop operations costs')
                    ->descriptionIcon('heroicon-m-credit-card')
                    ->color('danger'),
                
                Stat::make('Pending Orders', $pendingOrders)
                    ->description('Awaiting processing')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),
                
                Stat::make('Total Products', $totalProducts)
                    ->description($totalOrders . ' total orders')
                    ->descriptionIcon('heroicon-m-cube')
                    ->color('primary'),
            ];
        });
    }
}
