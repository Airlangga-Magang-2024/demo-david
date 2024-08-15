<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $recordTitleAttribute = 'street';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('street')
                    ->required()
                    ->maxLength(255)
                    ->label('Jalan'),
                Forms\Components\TextInput::make('zip')
                    ->required()
                    ->maxLength(255)
                    ->label('Kode Pos'),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255)
                    ->label('Kota'),
                Forms\Components\TextInput::make('state')
                    ->required()
                    ->maxLength(255)
                    ->label('Provinsi'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('street')
                    ->label('Jalan'),
                Tables\Columns\TextColumn::make('zip')
                    ->label('Kode Pos'),
                Tables\Columns\TextColumn::make('city')
                    ->label('Kota'),
                Tables\Columns\TextColumn::make('state')
                    ->label('Provinsi'),
                Tables\Columns\TextColumn::make('country')
                    ->label('Negara'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
