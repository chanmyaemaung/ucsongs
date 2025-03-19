<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongResource\Pages;
use App\Models\Song;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SongResource extends Resource
{
    protected static ?string $model = Song::class;

    /**
     * Navigation Configuration
     * ----------------------
     * This is the parent menu item for all song-related resources
     */
    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    protected static ?string $navigationGroup = 'Song Books';
    protected static ?string $navigationLabel = 'Songs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Grid::make([
                    'default' => 1,
                    'md' => 3,
                ])
                    ->schema([
                        \Filament\Forms\Components\Section::make(__('Song Information'))
                            ->description(__('Enter the main song details here'))
                            ->collapsible()
                            ->columnSpan([
                                'default' => 1,
                                'md' => 2,
                            ])
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->label(__('Title'))
                                    ->placeholder(__("Enter the song title (e.g., 'Blessing of Glory')"))
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->label(__('Lyrics/Content'))
                                    ->placeholder(__('Enter song lyrics or content here...'))
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('audio_files')
                                    ->multiple()
                                    ->disk('public')
                                    ->directory('songs')
                                    ->acceptedFileTypes(['audio/*', 'application/octet-stream'])
                                    ->maxSize(40960) // 40MB
                                    ->label(__('Audio Files'))
                                    ->placeholder(__('Upload MP3, MIDI, WAV or other audio formats'))
                                    ->helperText(__('Supported formats: MP3, MIDI, WAV, and other audio formats. Max file size: 40MB.'))
                                    ->columnSpanFull(),
                            ]),

                        \Filament\Forms\Components\Grid::make(1)
                            ->columnSpan([
                                'default' => 1,
                                'md' => 1,
                            ])
                            ->schema([
                                \Filament\Forms\Components\Section::make(__('Song Categories'))
                                    ->description(__('Select song classifications'))
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\Select::make('author_id')
                                            ->relationship('author', 'name')
                                            ->label(__('Author/Source'))
                                            ->placeholder(__('Select author or source'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Forms\Components\Select::make('composer_id')
                                            ->relationship('composer', 'name')
                                            ->label(__('Music Composer'))
                                            ->placeholder(__('Select music composer'))
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Forms\Components\Select::make('year_id')
                                            ->relationship('year', 'year')
                                            ->label(__('Category Year'))
                                            ->placeholder(__('Select category year'))
                                            ->searchable()
                                            ->preload()
                                            ->required(false)
                                            ->nullable(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__('Author/Source'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('composer.name')
                    ->label(__('Music Composer'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('year.year')
                    ->label(__('Category Year'))
                    ->sortable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(function (Song $record) {
                return Pages\EditSong::getUrl(['record' => $record]);
            });
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
            'index' => Pages\ListSongs::route('/'),
            'create' => Pages\CreateSong::route('/create'),
            'view' => Pages\ViewSong::route('/{record}'),
            'edit' => Pages\EditSong::route('/{record}/edit'),
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
