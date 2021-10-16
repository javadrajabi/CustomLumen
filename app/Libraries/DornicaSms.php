<?php
namespace App\Libraries;

use App\Libraries\Jdf;
use App\Models\SmsLog;
use SoapClient;

class DornicaSms
{
    static public $config = array(
        'ENV' => '',
        'LIST_LIMIT' => 10,
        'MAX_FILE_SIZE' => 5,
        'API_ROOT' => '../',
        'PANEL_ROOT' => '../',
        'app_id' => '7091f524-fccb-453c-86e0-dacbdfd4c4bc',
        'app_id_sp' => '1a8182ee-6168-40fd-98bb-94b5e1324de3',
        'SMS_APPOINTMENT_BODYID' => 56200,
        'SMS_APPOINTMENT_TEXT' => "کاربر گرامی، نوبت شما برای تاریخ ; ; شد. با تشکر ;.",
        'SMS_LOGIN_BODYID' => 56208,
        'SMS_LOGIN_TEXT' => "کاربر گرامی کد فعالسازی شما: ; جهت ورود ارسال شد"
    );

  static function send( $text, $mobiles, $sp_id, $member_id, $Type = 1)
    {

        ini_set("soap.wsdl_cache_enabled", "0");
        $encoding = "UTF-8"; //CP1256, CP1252
        $parameters['username'] = env('SMSPANEL_USERNAME');
        $parameters['password'] = env('SMSPANEL_PASSWORD');
        $parameters['text'] = $text;
        $parameters['to'] = $mobiles;
        switch ($Type) {
            case 1:
                $parameters['bodyId'] =DornicaSms::$config['SMS_APPOINTMENT_BODYID'];
                break;
            case 2:
                $parameters['bodyId'] = DornicaSms::$config['SMS_LOGIN_BODYID'];
                break;
        }

        if (!extension_loaded('soap'))
            echo 'Soap Extension Required!';
        try {
            $client = new SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl");
            $result = $client->SendByBaseNumber($parameters);
            $resp = $result->SendByBaseNumberResult;
            $SMSSentSuccessfully = strlen($resp) >= 15;
        } catch (Exception $e) {
            $result = false;
        }

        //Insert in sms_log table
        $FullSMSText = DornicaSms::GenerateSMSText($text);
        $InsertData = [
            'sp_id' => $sp_id,
            'member_id' => $member_id,
            'send_time' => (new Jdf)->jdate('Y/m/d H:i:s'),
            'status' => $SMSSentSuccessfully ? 1 : 0,
            'text' => $FullSMSText
        ];
        SmsLog::create($InsertData);
//        $db->insert('sms_log', $InsertData);
        return $result;
    }
   static function GenerateSMSText($Params, $Type = 1)
    {

        $FullText = '';
        switch ($Type) {
            case 1:
                $FullText = DornicaSms::$config['SMS_APPOINTMENT_TEXT'];
                break;
            case 2:
                $FullText = DornicaSms::$config['SMS_LOGIN_TEXT'];
                break;
        }

        foreach ($Params as $Param) {
            $FullText = preg_replace('/;/', $Param, $FullText, 1);
        }
        return $FullText;
    }
}
