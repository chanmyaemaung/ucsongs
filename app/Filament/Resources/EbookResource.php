<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EbookResource\Pages;
use App\Models\Ebook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * EbookResource - Manages digital books in different formats
 * This resource handles CRUD operations for ebooks, including different book types and metadata
 */
class EbookResource extends Resource
{
    protected static ?string $model = Ebook::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'Ebooks';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form

    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make(__('Basic Information'))
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Book Title'))
                                    ->placeholder(__('Enter book title'))
                                    ->helperText(__('e.g., The Art of Programming'))
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('author')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Author'))
                                    ->placeholder(__('Enter author name'))
                                    ->helperText(__('e.g., John Smith')),

                                Forms\Components\TextInput::make('publication_date')
                                    ->required()
                                    ->label(__('Publication Date'))
                                    ->placeholder(__('e.g., July ' . date('Y')))
                                    ->helperText(__('Enter publication date')),

                                Forms\Components\FileUpload::make('book_file')
                                    ->label(__('Book File'))
                                    ->helperText(__('Upload EPUB, MOBI or PDF file (Max 1GB)'))
                                    ->acceptedFileTypes(['application/epub+zip', 'application/pdf', 'application/x-mobipocket-ebook'])
                                    ->disk('public')
                                    ->maxSize(1024 * 1024) // 1GB in KB
                                    ->directory('ebooks')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make(__('Book Settings'))
                            ->schema([
                                Forms\Components\Select::make('book_type')
                                    ->required()
                                    ->options([
                                        'epub' => 'EPUB',
                                        'kindle' => 'Amazon Kindle',
                                        'pdf' => 'PDF',
                                        'mobi' => 'Mobi',
                                    ])
                                    ->label(__('Book Type'))
                                    ->helperText(__('Select book format')),

                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('Active Status'))
                                    ->helperText(__('Enable to make this book visible on the frontend'))
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label(__('Book Title')),
                Tables\Columns\TextColumn::make('book_file')
                    ->label(__('File'))
                    ->toggleable()
                    ->formatStateUsing(fn(?string $state): string => $state ? __('Uploaded') : __('Not Uploaded')),
                Tables\Columns\TextColumn::make('book_type')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'epub' => 'EPUB',
                        'kindle' => 'KINDLE',
                        'pdf' => 'PDF',
                        'mobi' => 'MOBI',
                        default => strtoupper($state),
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'epub' => 'primary',
                        'kindle' => 'primary',
                        'pdf' => 'primary',
                    })
                    ->label(__('Type')),
                Tables\Columns\TextColumn::make('author')
                    ->searchable()
                    ->sortable()
                    ->label(__('Author')),
                Tables\Columns\TextColumn::make('publication_date')
                    ->sortable()
                    ->label(__('Publication Date')),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('Created At')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('Updated At')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('book_type')
                    ->options([
                        'epub' => 'EPUB',
                        'kindle' => 'Amazon Kindle',
                        'pdf' => 'PDF',
                    ])
                    ->label(__('Book Type')),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('Active Status'))
                    ->placeholder(__('All Books'))
                    ->trueLabel(__('Active Books'))
                    ->falseLabel(__('Inactive Books')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('View Book'))
                    ->tooltip(__('View this book'))
                    ->icon('heroicon-o-eye')
                    ->color('success'),
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
            ->recordUrl(function (Ebook $record) {
                return Pages\EditEbook::getUrl(['record' => $record]);
            })
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label(__('Book Title')),
                        Infolists\Components\TextEntry::make('book_file')
                            ->label(__('Book File'))
                            ->url(fn($record) => $record->book_file ? asset('storage/' . $record->book_file) : '#')
                            ->formatStateUsing(fn(?string $state): string => $state ? __('Download') : __('No File'))
                            ->color(fn(?string $state): string => $state ? 'primary' : 'danger')
                            ->openUrlInNewTab(),
                        Infolists\Components\TextEntry::make('book_type')
                            ->label(__('Book Type'))
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'epub' => 'primary',
                                'kindle' => 'primary',
                                'pdf' => 'primary',
                            }),
                        Infolists\Components\TextEntry::make('author')
                            ->label(__('Author')),
                        Infolists\Components\TextEntry::make('publication_date')
                            ->label(__('Publication Date')),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make(__('Settings'))
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->label(__('Active Status'))
                            ->boolean(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime('d M Y H:i'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),
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
            'index' => Pages\ListEbooks::route('/'),
            'create' => Pages\CreateEbook::route('/create'),
            'view' => Pages\ViewEbook::route('/{record}'),
            'edit' => Pages\EditEbook::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Ebooks';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'author', 'book_type'];
    }
}
