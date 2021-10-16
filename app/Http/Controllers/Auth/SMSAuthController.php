<?php


namespace App\Http\Controllers\Auth;
use App\Http\Requests\SendCodeRequest;
use App\Http\Requests\SignInRequest;
use App\Jobs\SMSQueue;
use App\Models\UsersAuthCodes;
use App\Http\Controllers\Controller;
use App\Libraries\ResponseClass;
use App\Models\AppLoginLog;
use App\Models\Member;
use App\Models\Setting;
use App\Models\UserToken;
use phpseclib\Crypt\Rijndael;
use Propaganistas\LaravelPhone\PhoneNumber;

class SMSAuthController extends Controller
{

    public function signIn(SignInRequest $request)
    {
        $input = $request->all();
//        $validator = Validator::make($input, [
//            'mobile_number' => 'bail|required|numeric|min:11|phone:IR,mobile',
//            'hash' => 'bail|required|string|min:10|max:10',
//            'code' => 'bail|required|digits:4'
//        ], [
//            '*.*' => ':attribute درست وارد کنید',
//        ], ['mobile_number' => 'موبایل',
//            'hash' => 'هش کد',
//            'code' => 'کد تایید'
//        ]);
//        return response()->json($validator, 400);
//
//

        $device = '';
        $os = '';
//        $mobile = $input['mobile_number'];
        $mobile = PhoneNumber::make($input['mobile-number'], 'IR')->formatForMobileDialingInCountry('IR');
        $ip = $request->getClientIp();
//       return $request->getClientIp();

        $log = AppLoginLog::where('ip', $request->getClientIp())->orderBy('id', 'DESC')->first();
        $successful = $log['successful'] ?? 0;
        $attempts = $log['attempts'] ?? 0;
//        $datetime = $log['datetime'];

        $setting = Setting::select("banduration", "loginattempts")->where("status", "1")->first();
        $banduration = (int)$setting['banduration'];
        $loginattempts = $setting['loginattempts'];


        $log3 = AppLoginLog::select("id", "successful", "attempts", "datetime")
            ->where("ip", $ip)
            ->where("attempts", ">", $loginattempts)
            ->orderBy('id', 'DESC')
            ->first();

        $time = time();
        $datetime3 = $log3['datetime'] ?? $time;

        $datetime_result = ( int )$time - ( int )$datetime3;
        $result_time = floor($datetime_result / 60);
//        echo $datetime_result;exit;
        $code = mt_rand(1000, 9999);

        $rijndael = new Rijndael();
        $rijndael->setKey(\phpseclib\Crypt\Random::string(30));
        $hash = substr(md5($rijndael->encrypt(\phpseclib\Crypt\Random::string(10))), 0, 10);


        function loginprogress($mobile,$code, $hash, $request)
        {

            $last_auth_code = UsersAuthCodes::where('mobile', $mobile)
                ->where('code',$code )
                ->where('hash',$hash )
                ->whereNull('used_at')
                ->first(['id', 'created_at']);

            if (!$last_auth_code) {
                return ResponseClass::send(__("Authentication information is incorrect."),false, 403);

            }

            if ($last_auth_code->created_at < strtotime('-2 minute')) {
                return ResponseClass::send(__("The validation code has expired."),false,  403);


            }

            $user = Member::where('mobile', $mobile)->first();

            if (!$user) {
                return ResponseClass::send( __("The validation code is valid but no user with the given mobile number is registered."),false, 403);


            }

            if ($user->status != 1) {
                return ResponseClass::send( __("You do not have access to sign in."),false, 403);

            }

            UsersAuthCodes::where('id', $last_auth_code->id)
                ->update([
                    'used_at' => time(),
                ]);
            $userToken = UserToken::where('user_id', $user->id)->first();
            $record = [];
            $token = bin2hex(openssl_random_pseudo_bytes(64));
            if ($userToken) {
                $ok = 0;
                if ($userToken["expires_in"] > time()) {
                    $ok = 1;
                    $token = $userToken['token'];
                    $record = $userToken;
                } else {

                    if ($userToken->delete()) {
                        $record = array(
                            "user_id" => $user->id,
                            "issued_in" => time(),
                            "expires_in" => time() + (30 * 24 * 60 * 60),
                            "token_access" => $token,
                            "user_type" => '2',
                            // 30 days; 24 hours; 60 mins; 60 secs
                            "status" => "1"
                        );

                        $token_id = UserToken::create($record);


                        if ($token_id)
                            $ok = 1;
                    }
                }
            } else {
                $ok = 0;
                //		not token =>token add

                $record = array(
                    "user_id" => $user->id,
                    "issued_in" => time(),
                    "expires_in" => time() + (30 * 24 * 60 * 60),
                    "token_access" => $token,
                    "user_type" => '2',
                    // 30 days; 24 hours; 60 mins; 60 secs
                    "status" => "1"
                );
                $token_id = UserToken::create($record);
                if ($token_id)
                    $ok = 1;
            }

            $device = '';
            $os = '';
            $ip = $request->getClientIp();
            $log = AppLoginLog::where('ip', $request->getClientIp())->orderBy('id', 'DESC')->first();
            $successful = $log['successful'];

            ins_log($ip, 0, $successful, 'successful', $device, $os);
            return ResponseClass::send( [
                'user' => $user,
                'token' => $record
            ],true, 200);

        }

//        echo $attempts . ' ' . $loginattempts . ' ' . $result_time . ' ' . $banduration;
        if (((int)$attempts < (int)$loginattempts)) {


//            echo  BASE_DIR . '../../../Libraries/function.php';exit;
//            require __DIR__ . '..\..\..\Libraries\function.php';
            include(__DIR__ . '\..\..\..\Libraries\function.php');

            ins_log($ip, $attempts, $successful, 'attempts', $device, $os);
            return loginprogress($mobile, $input['code'],$input['hash'], $request);


        } else if ($result_time >= $banduration) {
            include(__DIR__ . '\..\..\..\Libraries\function.php');
            ins_log($ip, $attempts, $successful, 'attempts', $device, $os);
            return loginprogress( $mobile, $input['code'],$input['hash'],$request);

        } else {

            include(__DIR__ . '\..\..\..\Libraries\function.php');
            ins_log($ip, $attempts, $successful, 'attempts', $device, $os);
            return ResponseClass::send(

                __("You are not allowed to log in for :banduration minute. Please try again.",[':banduration'=>$banduration]),
                false,
                403);
        }


    }

    public function sendCode(SendCodeRequest $request)
    {

//        echo 'QWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW';
//        for($i=0; $i<=500; $i++) {
////        file_put_contents("ahdujwd.txt",'4e6d57f46re5f6474 f5674r85 74f857r4 85f');
//            dispatch(new SMSQueue([1247], '09357586173', '2', '1', 2));
////            Queue::push(new SMSQueue([1247], '09357586173', '2', '1', 2));
//        }



        $input = $request->all();


        $device = '';
        $os = '';
//        $mobile = $input['mobile_number'];
        $mobile = PhoneNumber::make($input['mobile-number'], 'IR')->formatForMobileDialingInCountry('IR');
        $ip = $request->getClientIp();
//       return $request->getClientIp();

        $log = AppLoginLog::where('ip', $request->getClientIp())->orderBy('id', 'DESC')->first();
        $successful = $log['successful'] ?? 0;
        $attempts = $log['attempts'] ?? 0;
//        $datetime = $log['datetime'];

        $setting = Setting::select("banduration", "loginattempts")->where("status", "1")->first();
        $banduration = (int)$setting['banduration'];
        $loginattempts = $setting['loginattempts'];


        $log3 = AppLoginLog::select("id", "successful", "attempts", "datetime")
            ->where("ip", $ip)
            ->where("attempts", ">", $loginattempts)
            ->orderBy('id', 'DESC')
            ->first();
        $time = time();
        $datetime3 = $log3['datetime'] ?? $time;

        $datetime_result = ( int )$time - ( int )$datetime3;
        $result_time = floor($datetime_result / 60);
//        echo $datetime_result;exit;
        $code = mt_rand(1000, 9999);

        $rijndael = new \phpseclib\Crypt\Rijndael();
        $rijndael->setKey(\phpseclib\Crypt\Random::string(30));
        $hash = substr(md5($rijndael->encrypt(\phpseclib\Crypt\Random::string(10))), 0, 10);

        function sendCode($input, $mobile, $code, $hash)
        {

            $user = Member::where("mobile", $input['mobile-number'])
                ->count();
//            $user_id = $user['id'];
            //کاربر وجود داشت
            if ($user<1)  {
                $user = Member::create([
                    'mobile' => $mobile,
                    'regdate' => '',
                    'status' => 1,
                    'sp_id' => 2,
                    'portalid' => 2
                ]);
            }


            UsersAuthCodes::create([
                'mobile' => $mobile,
                'code' => $code,
                'hash' => $hash,
                'created_at' => time(),
            ]);


            $member = Member::where(["mobile" => "$mobile", "sp_id" => 2])->first();
            $member->update([
                'activationCode' => $code,
            ]);
//                return ResponseClass::send(true,[$ip, $attempts, $successful, $datetime_result, $result_time, $banduration],200);
            // send sms


//            dispatch(new SMSQueue([$code], $user->mobile, $user->sp_id, $user->id, 2));
//            Queue::push(new SMSQueue([$code], $user->mobile, $user->sp_id, $user->id, 2));
//            $worker = new WorkerThreads([$code], $user->mobile, $user->sp_id, $user->id, 2);

//            if (DornicaSms::send([$code], $user->mobile, $user->sp_id, $user->id, 2)) {

//            if (true) {
            return ResponseClass::send(['hash' => $hash],true,  200);
//            } else {
//
//                ins_log($ip, $attempts - 1, $successful, 'attempts', $db, $device, $os);
//
//                return ResponseClass::send(false, 'send sms failed', 500);
//            }

        }

//        echo $attempts . ' ' . $loginattempts . ' ' . $result_time . ' ' . $banduration;
        if (((int)$attempts < (int)$loginattempts)) {
            ;
//            echo  BASE_DIR . '../../../Libraries/function.php';exit;
//            require __DIR__ . '..\..\..\Libraries\function.php';
            include(__DIR__ . '\..\..\..\Libraries\function.php');
            ins_log($ip, $attempts, $successful, 'attempts', $device, $os);
            return sendCode($input, $mobile, $code, $hash);

        } else if ($result_time >= $banduration) {
            include(__DIR__ . '\..\..\..\Libraries\function.php');
            ins_log($ip, $attempts, $successful, 'attempts', $device, $os);
            return sendCode($input, $mobile, $code, $hash);

        } else {

            include(__DIR__ . '\..\..\..\Libraries\function.php');
            ins_log($ip, $attempts, $successful, 'attempts', $device, $os);
            return ResponseClass::send(

                __("You are not allowed to log in for :banduration minute. Please try again.", ['banduration' => $banduration]),false,
                403);
        }


    }

    public function refreshToken()
    {
//        static $ttl = 60 * 24 * 365;
//        $token = $this->auth()->setTTL($ttl)->refresh();
//        $payload = $this->auth()->setToken($token)->payload();
//
//        return response()->json([
//            'status_code' => 'OK',
//            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => $payload->get('exp'),
//        ]);
    }

}
