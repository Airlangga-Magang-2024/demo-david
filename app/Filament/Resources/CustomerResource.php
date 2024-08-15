<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\shop\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;


    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';



    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->maxLength(255)
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->label('Email address')
                        ->required()
                        ->email()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('phone')
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('birthday')
                        ->maxDate('today'),
                ])
                ->columns(2)
                ->columnSpan(['lg' => fn (?Customer $record) => $record === null ? 3 : 2]),

            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Created at')
                        ->content(fn (Customer $record): ?string => $record->created_at?->diffForHumans()),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Last modified at')
                        ->content(fn (Customer $record): ?string => $record->updated_at?->diffForHumans()),
                ])
                ->columnSpan(['lg' => 1])
                ->hidden(fn (?Customer $record) => $record === null),
        ])
        ->columns(3);
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                ->label('Nomer Handphone')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('birthday')
                ->label('Tanngal Lahir')
                ->sortable()
                ->searchable(),
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
            RelationManagers\AddressRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
