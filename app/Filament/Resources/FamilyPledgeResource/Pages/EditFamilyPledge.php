<?php

namespace App\Filament\Resources\FamilyPledgeResource\Pages;

use App\Filament\Resources\FamilyPledgeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFamilyPledge extends EditRecord
{
    protected static string $resource = FamilyPledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getUpdatedNotificationTitle(): ?string
    {
        return "Family Pledge '{$this->record->title}' was updated successfully";
    }
}
