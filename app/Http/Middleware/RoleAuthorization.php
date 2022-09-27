<?php

namespace App\Http\Middleware;

use App\Models\Profile;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RoleAuthorization extends BaseMiddleware
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
        // return $next($request);
        try {
            $user = $this->auth->parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => false, 'message' => 'Token is Invalid'], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => false, 'message' => 'Token is Expired'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => false, 'message' => 'Authorization Token not found'], 401);
        }

        if ($user && in_array($user->role->role, $roles)) {
            $find = User::with('profil', 'role')->where('id', $user->id)->first();
            if ($find->role->role == 'umkm') {
                if ($find->profil->verifikasi == 1) {
                    return $next($request);
                } else {
                    return response()->json(['status' => false, 'message' => 'Anda belum diverifikasi'], 401);
                }
            } else {
                return $next($request);
            }
        }
        return response()->json(['status' => false, 'message' => 'You are not authorized'], 401);
    }

    private function unauthorized($message = null)
    {
        return response()->json(['error' => $message ?: 'Unauthorized'], 401);
    }
}
