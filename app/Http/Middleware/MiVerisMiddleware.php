<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class MiVerisMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('userData')) {
            return $next($request);
        } else {
            if (Session::has('userDataTmp')) {
                return redirect()->route('activar_cuenta_view');
            }else{
                return redirect()->route('login');
            }
        }
    }
}
