<?php

namespace App\Filament\Resources\FamilyPledgeResource\Pages;

use App\Filament\Resources\FamilyPledgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyPledges extends ListRecords
{
    protected static string $resource = FamilyPledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 