<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenActivity
{
    /**
     * Expire token if consumer app is iddle
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->last_activity < now()->subMinutes(User::INVALIDATE_TOKEN_IF_INACTIVE_IN_MINUTES)) {
            $user->tokens()->delete();

            return response()->json(['message' => 'Token expired due to inactivity'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $next($request);
    }
}
