<?php

namespace App\Filament\Resources\categoriesResource\Pages;

use App\Filament\Resources\CategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use App\Models\User;
use Filament\Notifications\Notification;

class Createcategories extends CreateRecord
{
    protected static string $resource = categoriesResource::class;

    protected function afterCreate(): void
    {
        /** @var Customer $customer */
        $categories = $this->record;

        /** @var User $user */
        $user = auth()->user();

        Notification::make()
            ->title('New Customer')
            ->icon('heroicon-o-user')
            ->body("**{$categories->name} has been added.**")
            ->actions([
                Action::make('View')
                    ->url(categoriesResource::getUrl('edit', ['record' => $categories->id])),
            ])
            ->sendToDatabase($user)
            ->send();
    }
}
