<?php

namespace App\Filament\Widgets;

use App\Models\Ebook;
use App\Models\FamilyPledge;
use App\Models\Song;
use App\Models\SongAuthor;
use App\Models\SongComposer;
use App\Models\SongYear;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('Songs'), Song::count())
                ->description(__('Total number of songs'))
                ->descriptionIcon('heroicon-m-musical-note')
                ->color('success'),

            Stat::make(__('Ebooks'), Ebook::count())
                ->description(__('Total number of ebooks'))
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),

            Stat::make(__('Family Pledges'), FamilyPledge::count())
                ->description(__('Total number of family pledges'))
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),

            Stat::make(__('Song Authors'), SongAuthor::count())
                ->description(__('Total number of song authors'))
                ->descriptionIcon('heroicon-m-pencil')
                ->color('warning'),

            Stat::make(__('Song Composers'), SongComposer::count())
                ->description(__('Total number of song composers'))
                ->descriptionIcon('heroicon-m-musical-note')
                ->color('info'),

            Stat::make(__('Song Years'), SongYear::count())
                ->description(__('Total number of song years'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),
        ];
    }
}
