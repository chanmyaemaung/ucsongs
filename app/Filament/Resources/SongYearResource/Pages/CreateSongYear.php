<?php

namespace App\Filament\Resources\SongYearResource\Pages;

use App\Filament\Resources\SongYearResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSongYear extends CreateRecord
{
    protected static string $resource = SongYearResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Year created')
            ->success();
    }
}
