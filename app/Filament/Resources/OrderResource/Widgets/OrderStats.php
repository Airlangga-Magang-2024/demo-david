<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Models\Shop\Order;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrderStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    // public function mount(): void
    // {
    //     $this->tableColumnSearches = []; // Inisialisasi properti di sini
    // }

    public array $tableColumnSearches = [];


    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    // protected function getPageTableQuery()
    // {
    //     // Pastikan $this->tableColumnSearches selalu array
    //     if (!is_array($this->tableColumnSearches)) {
    //         $this->tableColumnSearches = [];
    //     }

    //     return parent::getPageTableQuery();
    // }

    

    protected function getStats(): array
    {
        $orderData = Trend::model(Order::class)
            ->between(
                start: now()->subYear(),
                end: now()
            )
            ->perMonth()
            ->count();

            $query = $this->getPageTableQuery();

        return [
            Stat::make('Orders', $orderData->sum('count'))
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Stat::make('Open orders', $this->getPageTableQuery()->whereIn('status', ['open', 'processing'])->count()),
            Stat::make('Average price', number_format($this->getPageTableQuery()->avg('total_price'), 2)),
        ];
    }

    protected function getPageTableQuery()
    {
        return Order::query(); // Anda mungkin perlu menyesuaikan ini sesuai dengan kebutuhan Anda
    }
}
