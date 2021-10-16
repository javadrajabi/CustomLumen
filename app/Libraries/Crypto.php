<?php

namespace App\Libraries;

define('PASSPHRASE', 'BFB0875BBALF8D600W9C749B22F077DE');

class Crypto
{

   static public function cryptoJsAesDecrypt($jsonString)
    {
        $jsondata = json_decode($jsonString, true);
        $jsondata = json_decode($jsondata['data'], true);

        try {
            $salt = hex2bin($jsondata["s"]);
            $iv  = hex2bin($jsondata["iv"]);
        } catch (\Exception $e) {
            return null;
        }
        $ct = base64_decode($jsondata["ct"]);
        $concatedPassphrase = PASSPHRASE . $salt;
        $md5 = array();
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1] . $concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = json_decode(openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv), true);
        $data = !is_array($data) ? json_decode($data, true) : $data;
        return $data;
    }

    static public  function cryptoJsAesEncrypt($value)
    {
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx . PASSPHRASE . $salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32, 16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
