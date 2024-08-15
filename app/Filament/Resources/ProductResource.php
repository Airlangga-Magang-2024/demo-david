<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\shop\Product;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use App\Filament\Clusters\ShopProduct;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Str; // Tambahkan ini
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Widgets\CustomerOverview;












class ProductResource extends Resource
{
    protected static ?int $navigationSort = 0;

    protected static ?string $cluster = ShopProduct::class;

    protected static ?string $model = Product::class;


    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function form(Form $form): Form

    {
        return $form

                ->schema([
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                            if ($operation !== 'create') {
                                                return;
                                            }

                                            $set('slug', Str::slug($state));
                                        }),

                                    Forms\Components\TextInput::make('slug')
                                        ->disabled()
                                        ->dehydrated()
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(Product::class, 'slug', ignoreRecord: true),

                                    Forms\Components\MarkdownEditor::make('description')
                                        ->columnSpan('full'),
                                ])
                                ->columns(2),

                                Forms\Components\Section::make('Images')
                                ->schema([

                                SpatieMediaLibraryFileUpload::make('media')
                                // FileUpload::make('media')
                                    // ->collection('product-images')
                                    // ->multiple()
                                    // ->maxFiles(5)
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),




                            Forms\Components\Section::make('Pricing')
                                ->schema([
                                    Forms\Components\TextInput::make('price')
                                        ->numeric()
                                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                        ->required(),

                                    Forms\Components\TextInput::make('old_price')
                                        ->label('Compare at price')
                                        ->numeric()
                                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                        ->required(),

                                    Forms\Components\TextInput::make('cost')
                                        ->label('Cost per item')
                                        ->helperText('Customers won\'t see this price.')
                                        ->numeric()
                                        ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                        ->required(),
                                ])
                                ->columns(2),
                            Forms\Components\Section::make('Inventory')
                                ->schema([
                                    Forms\Components\TextInput::make('sku')
                                        ->label('SKU (Stock Keeping Unit)')
                                        ->unique(Product::class, 'sku', ignoreRecord: true)
                                        ->maxLength(255)
                                        ->required(),

                                    Forms\Components\TextInput::make('barcode')
                                        ->label('Barcode (ISBN, UPC, GTIN, etc.)')
                                        ->unique(Product::class, 'barcode', ignoreRecord: true)
                                        ->maxLength(255)
                                        ->required(),

                                    Forms\Components\TextInput::make('qty')
                                        ->label('Quantity')
                                        ->numeric()
                                        ->rules(['integer', 'min:0'])
                                        ->required(),

                                    Forms\Components\TextInput::make('security_stock')
                                        ->helperText('The safety stock is the limit stock for your products which alerts you if the product stock will soon be out of stock.')
                                        ->numeric()
                                        ->rules(['integer', 'min:0'])
                                        ->required(),
                                ])
                                ->columns(2),

                            Forms\Components\Section::make('Shipping')
                                ->schema([
                                    Forms\Components\Checkbox::make('backorder')
                                        ->label('This product can be returned'),

                                    Forms\Components\Checkbox::make('requires_shipping')
                                        ->label('This product will be shipped'),
                                ])
                                ->columns(2),
                        ])
                        ->columnSpan(['lg' => 2]),

                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make('Status')
                                ->schema([
                                    Forms\Components\Toggle::make('is_visible')
                                        ->label('Visible')
                                        ->helperText('This product will be hidden from all sales channels.')
                                        ->default(true),

                                    Forms\Components\DatePicker::make('published_at')
                                        ->label('Availability')
                                        ->default(now())
                                        ->required(),
                                ]),

                            Forms\Components\Section::make('Associations')
                                ->schema([
                                    Forms\Components\Select::make('brands_id') // Sesuaikan nama kolom jika diperlukan
                                    ->relationship('brands', 'name') // 'brands' adalah nama metode relasi di model Product
                                    ->required(),
                                    Forms\Components\Select::make('categories_id') // Sesuaikan nama kolom jika diperlukan
                                    ->relationship('categories', 'name') // 'brands' adalah nama metode relasi di model Product
                                    ->required(),


                                    // Forms\Components\Select::make('categories_id') // Sesuaikan nama kolom jika diperlukan
                                    // ->relationship('categories', 'name') // 'categories' adalah nama metode relasi di model Product
                                    // ->required()
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
                //
                Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
                ->label('Image'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('brands.name')
                // ->searchable()
                // ->sortable()
                ->toggleable(),

            Tables\Columns\IconColumn::make('is_visible')
                ->label('Visibility')
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('price')
                ->label('Price')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('sku')
                ->label('SKU')
                ->searchable()
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('qty')
                ->label('Quantity')
                ->searchable()
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('security_stock')
                ->searchable()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),

            Tables\Columns\TextColumn::make('published_at')
                ->label('Publish Date')
                ->date()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),
                // ->collection('product-images'),

            ])
            ->filters([
                //
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
            //
           
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }


    public static function getWidgets(): array
    {
    return [
        CustomerOverview::class,
    ];
    }


}
