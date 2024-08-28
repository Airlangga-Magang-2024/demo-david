<?php

namespace App\Filament\Widgets;

use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $startDate = !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            Carbon::now()->subMonth();

        $endDate = !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            Carbon::now();

        $isBusinessCustomersOnly = $this->filters['businessCustomersOnly'] ?? null;

        $revenue = $this->getRevenue($startDate, $endDate);
        $newCustomers = $this->getNewCustomers($startDate, $endDate);
        $newOrders = $this->getNewOrders($startDate, $endDate);

        return [
            Stat::make('Revenue', '$' . $this->formatNumber($revenue))
                ->description($this->getRevenueChangeDescription($startDate, $endDate))
                ->descriptionIcon($revenue >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getRevenueChartData($startDate, $endDate))
                ->color($revenue >= 0 ? 'success' : 'danger'),
            Stat::make('New customers', $this->formatNumber($newCustomers))
                ->description($this->getCustomerChangeDescription($startDate, $endDate))
                ->descriptionIcon($newCustomers >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getCustomerChartData($startDate, $endDate))
                ->color($newCustomers >= 0 ? 'success' : 'danger'),
            Stat::make('New orders', $this->formatNumber($newOrders))
                ->description($this->getOrderChangeDescription($startDate, $endDate))
                ->descriptionIcon($newOrders >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getOrderChartData($startDate, $endDate))
                ->color($newOrders >= 0 ? 'success' : 'danger'),
        ];
    }

    protected function getRevenue(Carbon $startDate, Carbon $endDate): float
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');
    }

    protected function getNewCustomers(Carbon $startDate, Carbon $endDate): int
    {
        return Customer::whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    protected function getNewOrders(Carbon $startDate, Carbon $endDate): int
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    protected function getRevenueChangeDescription(Carbon $startDate, Carbon $endDate): string
    {
        $previousPeriodStart = $startDate->copy()->subDays($endDate->diffInDays($startDate));
        $previousRevenue = $this->getRevenue($previousPeriodStart, $startDate);
        $currentRevenue = $this->getRevenue($startDate, $endDate);

        $change = $previousRevenue != 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 100;

        return number_format(abs($change), 1) . '% ' . ($change >= 0 ? 'increase' : 'decrease');
    }

    protected function getCustomerChangeDescription(Carbon $startDate, Carbon $endDate): string
    {
        $previousPeriodStart = $startDate->copy()->subDays($endDate->diffInDays($startDate));
        $previousCustomers = $this->getNewCustomers($previousPeriodStart, $startDate);
        $currentCustomers = $this->getNewCustomers($startDate, $endDate);

        $change = $previousCustomers != 0 ? (($currentCustomers - $previousCustomers) / $previousCustomers) * 100 : 100;

        return number_format(abs($change), 1) . '% ' . ($change >= 0 ? 'increase' : 'decrease');
    }

    protected function getOrderChangeDescription(Carbon $startDate, Carbon $endDate): string
    {
        $previousPeriodStart = $startDate->copy()->subDays($endDate->diffInDays($startDate));
        $previousOrders = $this->getNewOrders($previousPeriodStart, $startDate);
        $currentOrders = $this->getNewOrders($startDate, $endDate);

        $change = $previousOrders != 0 ? (($currentOrders - $previousOrders) / $previousOrders) * 100 : 100;

        return number_format(abs($change), 1) . '% ' . ($change >= 0 ? 'increase' : 'decrease');
    }

    protected function getRevenueChartData(Carbon $startDate, Carbon $endDate): array
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->pluck('total', 'date')
            ->take(7)
            ->toArray();
    }


    protected function getCustomerChartData(Carbon $startDate, Carbon $endDate): array
    {
        return Customer::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->pluck('count', 'date')
            ->take(7)
            ->toArray();
    }

    protected function getOrderChartData(Carbon $startDate, Carbon $endDate): array
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->pluck('count', 'date')
            ->take(7)
            ->toArray();
    }

    protected function formatNumber(float $number): string
    {
        if ($number < 1000) {
            return (string) Number::format($number, 0);
        }

        if ($number < 1000000) {
            return Number::format($number / 1000, 2) . 'k';
        }

        return Number::format($number / 1000000, 2) . 'm';
    }
}
