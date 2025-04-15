<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];

        
    }

        // Redirect to user list page after creating a user
        protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }
}
