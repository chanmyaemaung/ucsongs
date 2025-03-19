<?php

namespace App\Filament\Widgets;

use App\Models\Ebook;
use Filament\Widgets\ChartWidget;

class EbookTypeChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Ebook Types';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Ebook::select('book_type')
            ->selectRaw('count(*) as count')
            ->groupBy('book_type')
            ->get();

        $labels = $data->pluck('book_type')->map(fn($type) => __($type))->toArray();
        $values = $data->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'data' => $values,
                    'backgroundColor' => ['#36A2EB', '#4BC0C0', '#9966FF', '#FF9F40', '#FF6384'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'aspectRatio' => 1.5,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 12,
                        'padding' => 10,
                    ],
                ],
            ],
            'cutout' => '60%',
        ];
    }
}
