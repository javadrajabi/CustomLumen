<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\ServiceProvider;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

//use App\Libraries\Crypt as Crypt;
//use mysql_xdevapi\Exception;


class UPAuthController extends Controller
{

    public function register(Request $request)
    {
        if ($request->type == 'email') {
            $v = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:3|confirmed',
                'name' => 'required|min:3'

            ]);
            if ($v->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }


            Member::create([
//                'mobile' => $mobile,
                'regdate' => '',
                'status' => 1,
                'sp_id' => 2,
                'portalid' => 2
            ]);

            $user = new User;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);
//            $user->password = bcrypt($request->password);
            $user->user_type_Id = 1;
            $user->display_name = $request->display_name;
            $user->save();
            return response()->json(['status' => 'success'], 200);

        } elseif ($request->type == 'phone') {
            $v = Validator::make($request->all(), [
                'password' => 'required|min:3|confirmed',
                'phone' => 'required|digits:11|unique:users',
                'name' => 'required'

            ]);
            if ($v->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }
            $user = new User;
            $user->phone = $request->phone;
            $user->password = app('hash')->make($request->password);
//            bcrypt($request->password);
            $user->user_type_Id = 1;
            $user->display_name = $request->display_name;
            $user->save();
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'errors' => 'bad request'
            ], 422);
        }


    }

    public function login(Request $request)
    {
        $credentials = [];
        if (strpos($request->username, '@')) {
            $v = Validator::make($request->all(), [

                'username' => 'required|email',
                'password' => 'required|min:3',
            ]);
            if ($v->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors(),
                ], 422);
            }
            $credentials['email'] = $request->username;
        } else {
            $v = Validator::make($request->all(), [
                'username' => 'required|digits:11',
                'password' => 'required|min:3',
            ]);
            if ($v->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors(),
                ], 422);
            }
            $credentials['phone'] = $request->username;
        }
        $credentials['password'] = sha1(md5(GetSQLValueString($request->password, 'def')));;

        $user = User::where($credentials)->first();

        $userToken = UserToken::where('user_id', $user->id);

        $username = GetSQLValueString( $request[ 'username' ], 'def' );
        $pass = sha1( md5( GetSQLValueString( $request[ 'password' ], 'def' ) ) );
        $user= ServiceProvider::select("id",   "name", "user", "mobile", "status" )->
        where( "user", $username )->
        where( "pass", $pass )->
        where( function($q) use ($request) {
            $q->where('id', $request[ 'sp_id' ])
                ->orWhere('parent_id', $request[ 'sp_id' ]);
        })->
        where( "status", 1 );
        $user_id = $user[ 'id' ];
        //کاربر وجود داشت
        if ( $user_id > 0 ) {

        }


//[
//                        'data' => $_Data,
//                        'success' => true
//                    ]
//        $token = $this->guard()->claims(['service' => $SERVICE])->setTTL($ttl)->login($user);
////        $token=$this->guard()->setTTl(60 * 24 * 365)->attempt($credentials);
//        $payload = $this->auth()->payload();


    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public
    function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public
    function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['status' => 'error', 'error' => 'refresh_token_error'], 401);
    }

    private
    function guard()
    {
        return Auth::guard('api');
    }
}
