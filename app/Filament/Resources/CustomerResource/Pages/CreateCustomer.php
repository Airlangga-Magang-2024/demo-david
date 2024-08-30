<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use App\Models\User;
use Filament\Notifications\Notification;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterCreate(): void
    {
        /** @var Customer $customer */
        $customer = $this->record;

        /** @var User $user */
        $user = auth()->user();

        Notification::make()
            ->title('New Customer')
            ->icon('heroicon-o-user')
            ->body("**{$customer->name} has been added.**")
            ->actions([
                Action::make('View')
                    ->url(CustomerResource::getUrl('edit', ['record' => $customer->id])),
            ])
            ->sendToDatabase($user)
            ->send();
    }

}
