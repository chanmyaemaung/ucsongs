<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongYearResource\Pages;
use App\Models\SongYear;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SongYearResource extends Resource
{
    protected static ?string $model = SongYear::class;

    /**
     * Navigation Configuration
     * ----------------------
     * This is a child menu item under the Songs parent menu
     */
    protected static ?string $navigationGroup = 'Song Books';
    protected static ?string $navigationLabel = 'Years';

    /**
     * Parent Menu Configuration
     * ------------------------
     * These settings define how this resource appears under the Songs parent menu
     */
    protected static ?string $navigationParentItem = 'Songs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Year Information'))
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2100)
                            ->placeholder(__('Enter year (e.g., 1990)'))
                            ->label(__('Year')),
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->placeholder(__('Enter description for this year group'))
                            ->label(__('Year Description')),
                        Forms\Components\FileUpload::make('image')
                            ->directory('years')
                            ->image()
                            ->imageEditor()
                            ->nullable()
                            ->label(__('Year Image'))
                            ->placeholder(__('Upload year image')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year')
                    ->searchable()
                    ->sortable()
                    ->label(__('Year')),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('Image')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSongYears::route('/'),
            'create' => Pages\CreateSongYear::route('/create'),
            'edit' => Pages\EditSongYear::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }
}
