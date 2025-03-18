<?php

namespace App\Filament\Resources\SongAuthorResource\Pages;

use App\Filament\Resources\SongAuthorResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSongAuthor extends CreateRecord
{
    protected static string $resource = SongAuthorResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Author created')
            ->success();
    }
}
