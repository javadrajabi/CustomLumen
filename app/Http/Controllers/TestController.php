<?php

namespace App\Http\Controllers;

use App\Libraries\ResponseClass;
use Illuminate\Http\Request;

class TestController extends AuthController
{

    public function test(Request $request)
    {


        function decryp($text)
        {
            $key = 'MySecretKeyForEncryptionAndDecry'; // 32 chars
            $iv = 'helloworldhellow'; // 16 chars
            $method = 'aes-256-cbc';
            return openssl_decrypt($text, $method, $key, 0, $iv);
        }

        function encryp($text)
        {
            $key = 'MySecretKeyForEncryptionAndDecry'; // 32 chars
            $iv = 'helloworldhellow'; // 16 chars
            $method = 'aes-256-cbc';
            //   $text should be String
            return openssl_encrypt($text, $method, $key, 0, $iv);
        }


        return ResponseClass::send(

           [
               $request->all()['data'],
               encryp($request->all()['data']),
               decryp($request->all()['data']),
           ]

        );

    }

}
