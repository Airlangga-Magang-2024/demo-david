<?php

namespace App\Filament\Resources\Blog\LinkResource\Pages;

use App\Filament\Resources\Blog\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLink extends ViewRecord
{
    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            // Hapus atau ganti LocaleSwitcher jika tidak tersedia
            // Anda bisa membuat action lain sesuai kebutuhan
        ];
    }
}
