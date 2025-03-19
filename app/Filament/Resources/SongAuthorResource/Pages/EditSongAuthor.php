<?php

namespace App\Filament\Resources\SongAuthorResource\Pages;

use App\Filament\Resources\SongAuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSongAuthor extends EditRecord
{
    protected static string $resource = SongAuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle('Author deleted'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
