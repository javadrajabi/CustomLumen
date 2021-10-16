<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class FirebaseMessage
{

    function FirebaseMessage()
    {
    }


    static public function send($device_token, $title, $body)
    {
//        $device_tokens =[];
        return self::sendNotification($device_token, array(
            "title" => $title,
            "body" => $body,
            "sound"=> 'default'
        ));
    }

    /**
     * Write code on Method
     *
     * @return string()
     */

    static public function sendNotification($device_tokens, $message)
    {
        $SERVER_API_KEY = 'AAAAcHnDgZs:APA91bGgpko6JxFX7gX1q4B7ClTNLLJU53pgyqI6HWEeX1A_J-rmnIXRMyxu3uEFtrSWfTSK9dvGUWWdxjnY1RhuWjdnkY3Aa4zS_89XGA_n5nvWgmYmqCNtW0g8sLD4zSeUrF6PWUWc';

        $url = 'https://fcm.googleapis.com/fcm/send';
            // payload data, it will vary according to requirement
        $data = [
            "registration_ids" => $device_tokens,
            "notification" => $message
        ];


        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];


//        $response = Http::withHeaders($headers)->post('https://fcm.googleapis.com/fcm/send', $data);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
