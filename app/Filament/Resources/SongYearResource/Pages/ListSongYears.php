<?php

namespace App\Filament\Resources\SongYearResource\Pages;

use App\Filament\Resources\SongYearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSongYears extends ListRecords
{
    protected static string $resource = SongYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
