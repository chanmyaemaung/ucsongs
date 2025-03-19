<?php

namespace App\Filament\Resources\FamilyPledgeResource\Pages;

use App\Filament\Resources\FamilyPledgeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFamilyPledge extends CreateRecord
{
    protected static string $resource = FamilyPledgeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return "Family Pledge '{$this->record->title}' was created successfully";
    }
}
