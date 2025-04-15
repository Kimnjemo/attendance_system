<?php

namespace App\Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomAccountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            stat::make(label: "USERS", value:10)
            ->description(description: 'Total number of users')
            ->descriptionIcon('heroicon-m-user-group')
             ->color('success')
             ->chart([2, 10, 4, 6, 9, 20, 19, 31, 35]),

            stat::make(label: "EMPLOYEE", value:7)
            ->description('Active employees')
            ->descriptionIcon('heroicon-m-user-group') // 👈 icon for multiple employees
            ->color('primary')
            ->chart([2, 10, 4, 6, 9, 20, 119, 131, 135]),


            stat::make(label: "LOCATION", value:14)
            ->description('Offices worldwide')
             ->descriptionIcon('heroicon-m-map-pin')
            ->color('info')
            ->chart([2, 18, 20, 26, 39, 80, 49, 51, 100])
            ,
        ];
    }
}
