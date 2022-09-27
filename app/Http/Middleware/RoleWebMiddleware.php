<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RoleWebMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        try {
            // $user = $this->auth->parseToken()->authenticate();
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            return redirect('authenticate');
        } catch (TokenExpiredException $e) {
            return redirect('authenticate');
        } catch (JWTException $e) {
            return redirect('authenticate');
        }

        if ($user && in_array($user->role->role, $roles)) {
            if ($user->role->role == 'admin') {
                # code...
                return $next($request);
            }
            return redirect('authenticate');
        }
    }
}
