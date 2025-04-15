<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup;
use Filament\Support\Facades\FilamentView;
use Filament\Pages\Dashboard;


class SamPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('sam')
            ->path('sam')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
               // Widgets\AccountWidget::class,
              //  Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])


            ->renderHook('panels::layout', fn () => view('layouts.panel')) // 👈 this is key
            ->pages([
                // your pages
                Dashboard::class,
            /*   ListUsers::class,

CreateUser::class,

EditUser::class,*/

            ])
            
            ->renderHook(
                'panels::layout',
                fn () => view('layouts.panel') // 👈 THIS will override the layout
            );
            ;





        }
         

            public function navigation(): array
            {
                return [
                    NavigationGroup::make()
                        ->label('User Management')
                        ->items([
                            Pages\ListUsers::class,
                            Pages\CreateUser::class,
                        ]),
            
                    NavigationGroup::make()
                        ->label('Settings')
                        ->items([
                            Pages\SystemSettings::class,
                            Pages\ProfileSettings::class,
                        ]),
                ];



            }
            


    
}
