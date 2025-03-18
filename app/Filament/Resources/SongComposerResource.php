<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongComposerResource\Pages;
use App\Models\SongComposer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SongComposerResource extends Resource
{
    protected static ?string $model = SongComposer::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    protected static ?string $navigationGroup = 'Song Books';

    protected static ?string $navigationLabel = 'Composers';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Composer Information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder(__("Enter composer's name"))
                            ->label(__('Composer Name')),
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->placeholder(__('Enter information about the composer'))
                            ->label(__('Composer Description')),
                        Forms\Components\FileUpload::make('image')
                            ->directory('composers')
                            ->image()
                            ->imageEditor()
                            ->nullable()
                            ->label(__('Composer Image'))
                            ->placeholder(__('Upload composer image')),
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
            'index' => Pages\ListSongComposers::route('/'),
            'create' => Pages\CreateSongComposer::route('/create'),
            'edit' => Pages\EditSongComposer::route('/{record}/edit'),
        ];
    }
}
