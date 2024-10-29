<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CaptureSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ambiente = env('APP_ENV');
        $host = $request->getHost();
        $subdomain = explode('.', $host)[1];
        /*if($ambiente == 'prod'){
            $subdomain = explode('.', $host)[1];
        }else{
            $subdomain = explode('.', $host)[2];
        }*/
        // dd($subdomain);
        Session::forget('subdomain');
        // Session::put('subdomain', $subdomain);
        Session::put('subdomain', 'veris');
        config(['app.subdomain' => Session::get('subdomain')]);
        // dump(Session::get('subdomain'));
        
        return $next($request);
    }
}
