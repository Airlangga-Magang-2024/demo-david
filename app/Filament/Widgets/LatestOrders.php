<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Squire\Models\Currency;
use Filament\Navigation\Menu;

class LatestOrders extends BaseWidget
{

    protected int | string |array $columnSpan = "full";

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())

            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('currency')
                    ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                // \Tables\Columns\TextColumn::make('money')
                //     ->currency('USD')
                //     ->summarize(\Filament\Tables\Columns\Summarizers\Sum::make()->currency()),
                Tables\Columns\TextColumn::make('total_price')
                 ->formatStateUsing(fn ($state) => '$' . number_format($state, 0, '.', ','))
                 ->searchable()
                 ->sortable(),
                //  ->summarize([
                // Tables\Columns\Summarizers\Sum::make()
                //  ->formatStateUsing(fn ($state) => '$' . number_format($state, 0, '.', ',')), // Format angka pada summary
                //     ]),
                Tables\Columns\TextColumn::make('shipping_price')
                    ->label('Shipping cost')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 0, '.', ','))
                    ->searchable()
                    ->sortable(),

                //     ->summarize([
                //    Tables\Columns\Summarizers\Sum::make()
                //     ->formatStateUsing(fn ($state) => '$' . number_format($state, 0, '.', ',')), // Format angka pada summary
                //        ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->date()
                    ->toggleable(),
                    ])

                ->actions([
                    Tables\Actions\EditAction::make(),
                    ]);




    }
}
