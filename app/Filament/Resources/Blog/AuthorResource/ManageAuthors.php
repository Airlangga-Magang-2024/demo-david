<?php

namespace App\Filament\Resources\Blog\AuthorResource\Pages;

use App\Filament\Exports\Blog\AuthorExporter;
use App\Filament\Resources\Blog\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ManageAuthors extends ManageRecords
{
    protected static string $resource = AuthorResource::class;

    protected function getActions(): array
    {
        return [
            
            Actions\CreateAction::make(),
        ];
    }
}
