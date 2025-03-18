<?php

namespace App\Filament\Resources\SongAuthorResource\Pages;

use App\Filament\Resources\SongAuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSongAuthors extends ListRecords
{
    protected static string $resource = SongAuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
