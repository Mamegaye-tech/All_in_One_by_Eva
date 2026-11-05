<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Déconnecte immédiatement un compte désactivé pendant sa session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        //   var_dump($user?->only(['id', 'email', 'is_active']), session()->getId());
        //   die();
        if ($user && ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Ce compte est désactivé. Contactez l’administratrice.']);
        }

        return $next($request);
    }
}