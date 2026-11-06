<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Usage : ->middleware('permission:clients.voir')
     * Plusieurs codes = il suffit d'en avoir un : 'permission:clients.voir,clients.gerer'
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        abort_unless($user, 401);

        foreach ($permissions as $code) {
            if ($user->aPermission($code)) {
                return $next($request);
            }
        }

        abort(403, 'Vous n’avez pas l’autorisation d’accéder à cette page.');
    }
}