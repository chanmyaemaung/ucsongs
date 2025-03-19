<?php

namespace App\Filament\Resources\SongResource\Pages;

use App\Filament\Resources\SongResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSong extends CreateRecord
{
    protected static string $resource = SongResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return "Song '{$this->record->title}' was created successfully";
    }
}
