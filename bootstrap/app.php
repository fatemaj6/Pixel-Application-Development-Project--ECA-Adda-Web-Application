<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'tier' => \App\Http\Middleware\EnsureTier::class,
            'payment.done' => \App\Http\Middleware\EnsurePaymentCompleted::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $exception, Request $request) {
            if ($request->routeIs('register.storeStep2')) {
                $request->session()->regenerateToken();

                return redirect()
                    ->route('register.step2')
                    ->with('status', 'Session expired. Please try again.');
            }
        });
    })->create();
