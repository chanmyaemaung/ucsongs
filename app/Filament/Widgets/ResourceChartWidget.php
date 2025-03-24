<?php

namespace App\Filament\Widgets;

use App\Models\Song;
use App\Models\SongAuthor;
use App\Models\SongComposer;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ResourceChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Song Authors and Composers';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get top 5 song authors with song counts
        $songsByAuthor = Song::select('author_id', DB::raw('count(*) as song_count'))
            ->groupBy('author_id')
            ->orderByDesc('song_count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $authorName = SongAuthor::find($item->author_id)?->name ?? 'Unknown';
                return [
                    'label' => $authorName,
                    'value' => (int)$item->song_count,
                ];
            });

        // Get top 5 song composers with song counts
        $songsByComposer = Song::select('composer_id', DB::raw('count(*) as song_count'))
            ->groupBy('composer_id')
            ->orderByDesc('song_count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $composerName = SongComposer::find($item->composer_id)?->name ?? 'Unknown';
                return [
                    'label' => $composerName,
                    'value' => (int)$item->song_count
                ];
            });

        // Prepare data for chart
        $authorLabels = $songsByAuthor->pluck('label')->toArray();
        $authorData = $songsByAuthor->pluck('value')->toArray();

        $composerLabels = $songsByComposer->pluck('label')->toArray();
        $composerData = $songsByComposer->pluck('value')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Song Authors',
                    'data' => $authorData,
                    'backgroundColor' => ['#36A2EB', '#4BC0C0', '#9966FF', '#FF9F40', '#FF6384'],
                ],
                [
                    'label' => 'Song Composers',
                    'data' => $composerData,
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                ],
            ],
            'labels' => $authorLabels, // Use only the author labels for consistency
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
