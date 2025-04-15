<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CustomAccountWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    //protected static string $navigationIcon = 'heroicon-o-home';


    protected static string $view = 'filament.pages.dashboard';

/*
    protected function getWidgets(): array
    {
        return [
            UserListWidget::class,
            
        
        ];
    }
*/
    protected function getHeaderWidgets(): array
    {
        return [
            CustomAccountWidget::class,
        ];
    }



}
