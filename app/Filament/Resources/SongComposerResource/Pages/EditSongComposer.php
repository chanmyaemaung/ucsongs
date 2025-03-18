<?php

namespace App\Filament\Resources\SongComposerResource\Pages;

use App\Filament\Resources\SongComposerResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSongComposer extends EditRecord
{
    protected static string $resource = SongComposerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle('Composer deleted'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Composer updated')
            ->success();
    }
}
