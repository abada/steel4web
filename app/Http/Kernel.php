<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * Class Kernel
 * @package App\Http
 */
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\UrlBase::class
    ];

    /**
     * The application's route middleware groups.
     * How this goes: There are several permissions that are created by seed, whose you can asign to a group of middlewares, then you can use this group on the routes
     * to apply the permissions to that expessific route. You can create as many groups as you want and the groups can have as many permissions as wanted too, just don`t
     * repeat the name of the group for satan`s sake.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\UrlBase::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\LocaleMiddleware::class,
        ],

        'admin' => [
            'web',
            'auth'
        ],'ver-cadastro' => [
            'web',
            'auth',
            'access.routeNeedsPermission:ver-cadastro',
        ],'criar-cadastro' => [
            'web',
            'auth',
            'access.routeNeedsPermission:criar-cadastro',
        ],'editar-cadastro' => [
            'web',
            'auth',
            'access.routeNeedsPermission:editar-cadastro',
        ],'deletar-cadastro' => [
            'web',
            'auth',
            'access.routeNeedsPermission:deletar-cadastro',
        ],'visualizar-importador' => [
            'web',
            'auth',
            'access.routeNeedsPermission:visualizar-importador',
        ],'criar-importacao' => [
            'web',
            'auth',
            'access.routeNeedsPermission:criar-importacao',
        ],'deletar-importacao' => [
            'web',
            'auth',
            'access.routeNeedsPermission:deletar-importacao',
        ],'visualizar-apontador' => [
            'web',
            'auth',
            'access.routeNeedsPermission:visualizar-apontador',
        ],'criar-apontacao' => [
            'web',
            'auth',
            'access.routeNeedsPermission:criar-apontacao',
        ],'visualizar-gestor' => [
            'web',
            'auth',
            'access.routeNeedsPermission:visualizar-gestor',
        ],'criar-lotes' => [
            'web',
            'auth',
            'access.routeNeedsPermission:criar-lotes',
        ],'editar-lotes' => [
            'web',
            'auth',
            'access.routeNeedsPermission:editar-lotes',
        ],'apontador' => [
            'web',
            'auth',
            'access.routeNeedsPermission:visualizar-apontador',
            'access.routeNeedsPermission:criar-apontacao',
        ],'importador' => [
            'web',
            'auth',
            'access.routeNeedsPermission:visualizar-importador',
            'access.routeNeedsPermission:criar-importacao',
            'access.routeNeedsPermission:deletar-importacao',
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        /**
         * Access Middleware
         */
        'access.routeNeedsRole' => \App\Http\Middleware\RouteNeedsRole::class,
        'access.routeNeedsPermission' => \App\Http\Middleware\RouteNeedsPermission::class,
    ];
}
