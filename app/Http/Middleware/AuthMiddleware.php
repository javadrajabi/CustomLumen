<?php

namespace App\Http\Middleware;

use App\Libraries\ResponseClass;
use App\Models\Member;
use App\Models\User;
use App\Models\UserToken;
use Closure;
use Illuminate\Support\Facades\App;

class AuthMiddleware
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
        if ($request->headers->has('Accept-Language')) {
            if (in_array($request->getLanguages()[0], ['en', 'fa'])) {
                App::setLocale($request->getLanguages()[0]);
            }
        }

        if ($request->bearerToken()) {

            $userToken = UserToken::where('token_access', $request->bearerToken())->first();

            if ($userToken) {

                if ($userToken->expires_in > time()) {

//                   Member::find($userToken->user_id);
                    $member= Member::select("id", "ostancode","shahrestancode",
                        "sp_id","fname", "lname", "mobile", "email",
                        "moaref", "image",  "birthday", "receive_notifications")
                        ->where('id',$userToken->user_id)->first()->attributesToArray();
                    $member['user_type']=$userToken->user_type;
                    $request['memberData5668'] = $member;
//                    var_dump($member['id']);exit;

//                    foreach($member as $a){
//                        echo "key:  value: ".$a."\n";
//                        $ignore = next($member);//separate key advancement - undesirable
//                    }
//                    exit;
//                    return response()->json(['ee'=>$request->all()]);
                    return $next($request);

                } else {
                    return ResponseClass::send('Token is\'nt valid.You do not have access.', false, 401);
                }

            } else {
                return ResponseClass::send('Token is\'nt valid.You do not have access.', false, 401);

            }
//            return UserToken::where('token_access',$request->bearerToken());
//            $request->attributes->add(['myAttribute' => 'myValue']);
//            return $next($request);
        } else {

            return ResponseClass::send('Authenticate ERROR.', false, 422);

        }

//        return $request->bearerToken();
//        \Request::get('myAttribute');
//        $request->get('myAttribute');
//        return $next($request);
    }
}
