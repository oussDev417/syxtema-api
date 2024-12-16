<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('lang')) {
            Session::put('lang', getDefaultLanguage());
            App::setLocale(Session::get('lang'));
        } else {
            App::setLocale(Session::get('lang'));
        }

        return $next($request);
    }
}
