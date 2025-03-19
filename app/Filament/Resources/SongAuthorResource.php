<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongAuthorResource\Pages;
use App\Models\SongAuthor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SongAuthorResource extends Resource
{
    protected static ?string $model = SongAuthor::class;

    /**
     * Navigation Configuration
     * ----------------------
     * This is a child menu item under the Songs parent menu
     */
    protected static ?string $navigationGroup = 'Song Books';
    protected static ?string $navigationLabel = 'Authors';

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
                Forms\Components\Section::make(__('Author Information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder(__("Enter author's name"))
                            ->label(__('Author Name')),
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->placeholder(__('Enter information about the author'))
                            ->label(__('Author Description')),
                        Forms\Components\FileUpload::make('image')
                            ->directory('authors')
                            ->image()
                            ->imageEditor()
                            ->nullable()
                            ->label(__('Author Image'))
                            ->placeholder(__('Upload author image')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('Name')),
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
            'index' => Pages\ListSongAuthors::route('/'),
            'create' => Pages\CreateSongAuthor::route('/create'),
            'edit' => Pages\EditSongAuthor::route('/{record}/edit'),
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
