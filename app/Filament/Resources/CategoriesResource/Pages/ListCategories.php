<?php

namespace App\Filament\Resources\categoriesResource\Pages;

use App\Filament\Resources\categoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class Listcategories extends ListRecords
{
    protected static string $resource = categoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
