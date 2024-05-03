<?php

namespace App\Http\Middleware;

use Laravel\Passport\Exceptions\OAuthServerException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use Closure;

class VerifyUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        $token = $request->header('user-token');
        $request->headers->set('authorization', 'Bearer ' . $token, true);
        $currentAuth = FALSE;

        if (Auth::guard('app_users_auth')->user()) {
            try {
                $currentAuth = Auth::guard('app_users_auth')->user();
                Auth::shouldUse('app_users_auth');
            } catch (OAuthServerException $e) {
                return responseApi(401, [], 'Unauthorized');
            } catch (Exception $e) {
                return responseApi(401, [], 'Unauthorized');
            }
        }

        if (null !== $token && $currentAuth) {
            return $next($request);
        }

        return responseApi(401, [], 'Unauthorized');
    }
}
