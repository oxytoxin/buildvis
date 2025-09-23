<?php

namespace App\Providers\Filament;

use App\Http\Middleware\CheckIfProjectManagerMiddleware;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ProjectManagerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('project-manager')
            ->path('project-manager')
            ->viteTheme('resources/css/filament/project-manager/theme.css')
            ->darkMode(false)
            ->defaultThemeMode(ThemeMode::Light)
            ->colors([
                'primary' => Color::Purple,
            ])
            ->discoverResources(in: app_path('Filament/ProjectManager/Resources'), for: 'App\\Filament\\ProjectManager\\Resources')
            ->discoverPages(in: app_path('Filament/ProjectManager/Pages'), for: 'App\\Filament\\ProjectManager\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/ProjectManager/Widgets'), for: 'App\\Filament\\ProjectManager\\Widgets')
            ->widgets([
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
                CheckIfProjectManagerMiddleware::class,
                Authenticate::class,
            ])
            ->darkMode(false);
    }
}
