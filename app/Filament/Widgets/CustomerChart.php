<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Tambahkan ini


class CustomersChart extends ChartWidget
{
    protected static ?string $heading = 'Total customers';

    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {

        Log::info('Fetching customers data...');

        $customersData = DB::table('customers')
        ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
        ->groupBy('hour')
        ->orderBy('hour')
        ->get()
        ->pluck('count', 'hour')
        ->toArray();

        Log::info('Customers Data:', $customersData);

        $data = [];
        for ($hour = 1; $hour <= 12; $hour++) {
            $data[] = $customersData[$hour] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' => $data,
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],

        ];
    }
}
