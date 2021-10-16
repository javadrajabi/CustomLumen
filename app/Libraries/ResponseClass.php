<?php

namespace App\Libraries;

class ResponseClass
{
    static public function send($data, $success = true, $statusCode = 200)
    {




        if ($data == null) {
            $data = [];
        }

        if (env('DEV')) {
            $data = Crypto::cryptoJsAesEncrypt(json_encode($data));
        }
//        if (is_array($data)) {


            return response()->json([
                'success' => $success ? 'true' : 'false',
                $success ? 'data' : 'error' => $data
            ], $statusCode);


//        } else {
//            return response()->json([
//                'success' => $success ? 'true' : 'false',
//                $success ? 'data' : 'error' => ['message' => $data]
//            ], $statusCode)->send();
//        }


    }
}
