<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class; 


        // Redirect to user list page after creating a user
        protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }
}
