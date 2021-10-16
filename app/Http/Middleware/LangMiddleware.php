<?php

namespace App\Http\Middleware;

use App\Libraries\ResponseClass;
use App\Models\Member;
use App\Models\User;
use App\Models\UserToken;
use Closure;
use Illuminate\Support\Facades\App;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//        $request->bearerToken();
//        print_r($request->getLanguages()[0]);exit;
//        $request->hasHeader('Accept-Language');
//        print($request->headers->has('Accept-Language'));exit;
        if($request->headers->has('Accept-Language')){
            if ( in_array($request->getLanguages()[0], ['en', 'fa'])) {
                App::setLocale($request->getLanguages()[0]);
            }
        }

        return $next($request);
    }
}
