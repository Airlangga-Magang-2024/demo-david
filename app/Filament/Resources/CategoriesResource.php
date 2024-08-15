<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CategoriesResource\Pages;
use App\Filament\Resources\CategoriesResource\RelationManagers;
use App\Models\shop\Categories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Filament\Clusters\ShopProduct;

class CategoriesResource extends Resource
{
    protected static ?string $model = categories::class; // Pastikan ini sesuai dengan nama model
    protected static ?int $navigationSort = 2;
    protected static ?string $cluster = ShopProduct::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->unique(categories::class, 'slug', ignoreRecord: true),
                            ]),

                        Forms\Components\Select::make('parent_id')
                            ->label('Parent')
                            ->relationship('parent', 'name', fn (Builder $query) => $query->whereNull('parent_id'))
                            ->searchable()
                            ->placeholder('Select parent category'),

                        Forms\Components\Toggle::make('is_visible')
                            ->label('Visible to customers.')
                            ->default(true),

                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Description'),
                    ])
                    ->columnSpan(['lg' => fn (?categories $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (categories $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (categories $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?categories $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Define columns here
                Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('slug')
                ->label('Slug')
                ->sortable()
                ->searchable(),



            Tables\Columns\BooleanColumn::make('is_visible')
                ->label('Visible')
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('Y-m-d H:i:s')
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime('Y-m-d H:i:s')
                ->sortable(),
            ])
            ->filters([
                // Define filters here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            // Define relations here
            // RelationManagers\ProductsRelationManager::class,
            \App\Filament\Resources\CategoriesResource\RelationManagers\ProductsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\Listcategories::route('/'),
            'create' => Pages\Createcategories::route('/create'),
            'edit' => Pages\Editcategories::route('/{record}/edit'),
        ];
    }
}
