<?php

namespace App\Filament\Resources\SongYearResource\Pages;

use App\Filament\Resources\SongYearResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSongYear extends EditRecord
{
    protected static string $resource = SongYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle('Year deleted'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getUpdatedNotificationTitle(): ?string
    {
        return "Year '{$this->record->year}' was updated successfully";
    }
}
