<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPanelAccess
{
    private array $publicRoutes = [
        'auth.login',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $panel = Filament::getCurrentPanel();

        if (!$panel || $this->isPublicRoute($request, $panel)) {
            return $next($request);
        }

        if (!auth()->check()) {
            return redirect()->route("filament.{$panel->getId()}.auth.login");
        }

        if (!$this->hasPanelAccess(auth()->user(), $panel->getId())) {
            abort(403, 'Доступ запрещен');
        }

        return $next($request);
    }

    protected function isPublicRoute(Request $request, Panel $panel): bool
    {
        $routeName = $request->route()?->getName();

        foreach ($this->publicRoutes as $route) {
            if ($routeName === "filament.{$panel->getId()}.{$route}") {
                return true;
            }
        }

        return false;
    }

    protected function hasPanelAccess($user, string $panel): bool
    {
        return match ($panel) {
            'admin' => $user->role_id === 1,
            'manager' => in_array($user->role_id, [1, 2]),
            'app' => true,
            default => false,
        };
    }
}
