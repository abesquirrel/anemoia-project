<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            $suspiciousPaths = ['wp-admin', '.env', 'config', 'admin', 'phpinfo'];

            foreach ($suspiciousPaths as $path) {
                if (str_contains($request->path(), $path)) {
                    EventLog::create([
                        'event_type' => 'suspicious_access',
                        'message' => 'Blocked access attempt to sensitive path: ' . $request->path(),
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                    break;
                }
            }

            // Continue normal 404 handling
            return null;
        });
    })->create();
