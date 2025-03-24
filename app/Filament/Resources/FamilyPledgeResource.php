<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyPledgeResource\Pages;
use App\Models\FamilyPledge;
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
 * FamilyPledgeResource - Manages family pledges in different languages
 * This resource handles CRUD operations for family pledges, including translations and individual pledge items
 */
class FamilyPledgeResource extends Resource
{
    // Define the model this resource manages
    protected static ?string $model = FamilyPledge::class;

    // Navigation settings for the admin panel
    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'Family Pledges';
    protected static ?int $navigationSort = 5;

    /**
     * Form configuration for creating and editing pledges
     * Includes sections for basic info, content, and individual pledge items
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make(__('Basic Information'))
                            ->schema([
                                Forms\Components\TextInput::make('language_code')
                                    ->required()
                                    ->maxLength(10)
                                    ->placeholder(__('e.g., en, my, ko'))
                                    ->helperText(__('ISO language code')),

                                Forms\Components\TextInput::make('language_name')
                                    ->required()
                                    ->maxLength(50)
                                    ->placeholder(__('e.g., English, Burmese, Korean')),

                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder(__('Family Pledge'))
                                    ->helperText(__('The title of the pledge'))
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make(__('Pledge Content'))
                            ->schema([
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->toolbarButtons([
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'heading',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                                    ->helperText(__('Enter the complete Family Pledge text with formatting. This will be displayed on the frontend.'))
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make(__('Individual Pledge Items'))
                            ->description(__('Create structured data for each pledge item. This allows for better control and interactive features in the frontend.'))
                            ->schema([
                                Forms\Components\Repeater::make('pledge_items')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('number')
                                                    ->label(__('Item Number'))
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->helperText(__('The sequence number of this pledge item (e.g., 1, 2, 3)')),

                                                Forms\Components\TextInput::make('id')
                                                    ->label(__('Item Identifier'))
                                                    ->placeholder('pledge-1')
                                                    ->helperText(__('Optional unique identifier for frontend use (e.g., pledge-1)')),
                                            ]),

                                        Forms\Components\RichEditor::make('text')
                                            ->label(__('Pledge Text'))
                                            ->required()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'link',
                                                'redo',
                                                'undo',
                                            ])
                                            ->helperText(__('The text content of this specific pledge item')),
                                    ])
                                    ->itemLabel(
                                        fn(array $state): ?string =>
                                        isset($state['number'], $state['text'])
                                            ? __('Pledge :number', ['number' => $state['number']]) . ': ' .
                                            (strlen($state['text']) > 40 ? substr(strip_tags($state['text']), 0, 40) . '...' : strip_tags($state['text']))
                                            : null
                                    )
                                    ->reorderable()
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->cloneable()
                                    ->addActionLabel(__('Add Pledge Item'))
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make(__('Publishing Options'))
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('Active Status'))
                                    ->helperText(__('Enable to make this pledge visible on the frontend'))
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger'),

                                Forms\Components\TextInput::make('display_order')
                                    ->label(__('Display Order'))
                                    ->integer()
                                    ->default(0)
                                    ->helperText(__('Lower values appear first in lists')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    /**
     * Table configuration for displaying pledges in a list
     * Shows key information and provides actions for view, edit, and delete
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('language_name')
                    ->label(__('Language'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('language_code')
                    ->label(__('Code'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('display_order')
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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Pledges')
                    ->trueLabel('Active Pledges')
                    ->falseLabel('Inactive Pledges'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Pledge')
                    ->tooltip('View this pledge')
                    ->icon('heroicon-o-eye')
                    ->color('success'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('display_order', 'asc');
    }

    /**
     * Infolist configuration for viewing pledge details
     * Displays formatted information in sections for better readability
     */
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Infolists\Components\TextEntry::make('language_name')
                            ->label(__('Language')),
                        Infolists\Components\TextEntry::make('language_code')
                            ->label(__('Language Code')),
                        Infolists\Components\TextEntry::make('title')
                            ->label(__('Title')),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make(__('Pledge Content'))
                    ->schema([
                        Infolists\Components\TextEntry::make('content')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make(__('Individual Pledge Items'))
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('pledge_items')
                            ->schema([
                                Infolists\Components\TextEntry::make('number')
                                    ->label(__('Item Number')),
                                Infolists\Components\TextEntry::make('id')
                                    ->label(__('Item ID'))
                                    ->visible(fn($state) => !empty($state)),
                                Infolists\Components\TextEntry::make('text')
                                    ->label(__('Content'))
                                    ->html()
                                    ->columnSpanFull(),
                            ])
                            ->visible(fn($state) => !empty($state))
                            ->columns(2),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make(__('Settings'))
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->label(__('Active Status'))
                            ->boolean(),
                        Infolists\Components\TextEntry::make('display_order')
                            ->label(__('Display Order')),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime(),
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
            'index' => Pages\ListFamilyPledges::route('/'),
            'create' => Pages\CreateFamilyPledge::route('/create'),
            'view' => Pages\ViewFamilyPledge::route('/{record}'),
            'edit' => Pages\EditFamilyPledge::route('/{record}/edit'),
        ];
    }

    /**
     * Navigation badge configuration
     * Shows total count of pledges and changes color based on count
     */
    public static function getNavigationLabel(): string
    {
        return 'Family Pledges';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    /**
     * Global search configuration
     * Enables searching pledges by title
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    /**
     * Customizes where users are directed after clicking a search result
     * Redirects to the view page instead of edit page for better user experience
     */
    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }
}
