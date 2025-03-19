<?php

namespace App\Filament\Resources\SongAuthorResource\Pages;

use App\Filament\Resources\SongAuthorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSongAuthor extends CreateRecord
{
    protected static string $resource = SongAuthorResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return "Author '{$this->record->name}' was created successfully";
    }
}
