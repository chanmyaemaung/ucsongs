<?php

namespace App\Filament\Resources\SongComposerResource\Pages;

use App\Filament\Resources\SongComposerResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSongComposer extends CreateRecord
{
    protected static string $resource = SongComposerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return "Composer '{$this->record->name}' was created successfully";
    }
}
