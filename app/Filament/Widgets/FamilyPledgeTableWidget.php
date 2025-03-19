<?php

namespace App\Filament\Widgets;

use App\Models\FamilyPledge;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class FamilyPledgeTableWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'Current Family Pledges';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FamilyPledge::query()
                    ->where('is_active', true)
                    ->orderBy('display_order')
            )
            ->columns([
                TextColumn::make('language_name')
                    ->label('Language')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('pledge_items')
                    ->label('Pledge Items')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return count($state) . ' items';
                        }
                        return '0 items';
                    }),
                TextColumn::make('display_order')
                    ->label('Display Order')
                    ->sortable(),
            ])
            ->actions([
                // No actions needed for the widget
            ])
            ->bulkActions([
                // No bulk actions needed for the widget
            ]);
    }
}
