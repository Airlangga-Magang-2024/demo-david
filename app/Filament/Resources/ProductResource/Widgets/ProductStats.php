<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use App\Filament\Resources\ProductResource\Pages\ListProducts;

class ProductStats extends BaseWidget
{

    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProducts::class;
    }

    
    protected function getStats(): array
    {
        return [

            Stat::make('Total Products', $this->getPageTableQuery()->count()),
            Stat::make('Product Inventory', $this->getPageTableQuery()->sum('qty')),
            Stat::make('Average price', number_format($this->getPageTableQuery()->avg('price'), 2)),
        ];
    }
}
