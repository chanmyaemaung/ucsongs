<?php

namespace App\Filament\Resources\SongComposerResource\Pages;

use App\Filament\Resources\SongComposerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSongComposers extends ListRecords
{
    protected static string $resource = SongComposerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
