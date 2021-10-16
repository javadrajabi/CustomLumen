<?php

namespace App\Libraries;


use App\Models\DeviceAccess;
use App\Models\Imei;
use App\Models\Notification;
use App\Models\NotificationText;

class FindChanges
{

    function FindChanges()
    {


    }


    static function check($lastAssign, $inputAssign)
    {
        $imei = Imei::where('imei', $inputAssign['imei'])->first();

        $device_token=array();
        $users= DeviceAccess::with('user')->where('imei_id',$imei->id)->get();
        foreach ($users as &$rec) {

            array_push($device_token, $rec->user->device_token);


        }
        $messageRes=null;
        $run=[];

        if ($inputAssign['lat'] != null) {
            $pointLocation = new pointLocation();
            $point = $inputAssign['lat'] . ',' . $inputAssign['lon'];

            $polygon = json_decode($imei->polygon);
//           print($polygon[0]);exit;
            $result = $pointLocation->isWithinBoundary($point, $polygon);




            $point2 = $lastAssign['lat'] . ',' . $lastAssign['lon'];
            $result2 = $pointLocation->isWithinBoundary($point2, $polygon);
             
           if($result!=$result2) {
            if ($result) {
                   Notification::create([
                    'notification_text_id' => 7,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id', 7)->first()->text);
            } else {
                   Notification::create([
                    'notification_text_id' => 6,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',6 )->first()->text);
            }}

        }
        if ($inputAssign['spd'] >120 && $lastAssign['spd']<120){
              Notification::create([
                'notification_text_id' => 3,
                'imei_id' => $imei->id,
                'seen' => '0'
            ]);
            $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',3 )->first()->text);
        }
        if ($lastAssign['cs'] != $inputAssign['cs']){
            if($inputAssign['cs']=='1'){
                   Notification::create([
                    'notification_text_id' =>8,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',8)->first()->text);
            }else{
                   Notification::create([
                    'notification_text_id' =>9,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',9 )->first()->text);
            }

        }
        if ($inputAssign['credit']<10000 && $lastAssign['credit']>10000){
               Notification::create([
                'notification_text_id' =>10,
                'imei_id' => $imei->id,
                'seen' => '0'
            ]);
            $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',10 )->first()->text);
        }
        if ($lastAssign['cbs'] != $inputAssign['cbs']){
            if($inputAssign['cbs']=='1'){
                  Notification::create([
                    'notification_text_id' =>2,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',2 )->first()->text);
            }else{
                  Notification::create([
                    'notification_text_id' =>1,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',1 )->first()->text);
            }


        }
        if ($lastAssign['do'] != $inputAssign['do']){
            if($inputAssign['do']=='1'){
                   Notification::create([
                    'notification_text_id' =>4,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',4 )->first()->text);
            }else{
                 Notification::create([
                    'notification_text_id' =>5,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',5 )->first()->text);
            }

        }
        if ($lastAssign['mid'] != $inputAssign['mid']){
               Notification::create([
                'notification_text_id' =>16,
                'imei_id' => $imei->id,
                'seen' => '0'
            ]);

            $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',16 )->first()->text);        }
        if ($lastAssign['acd'] != $inputAssign['acd']){
            if($inputAssign['acd']=='1'){
                Notification::create([
                    'notification_text_id' =>12,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',12 )->first()->text);
            }else{
                 Notification::create([
                    'notification_text_id' =>13,
                    'imei_id' => $imei->id,
                    'seen' => '0'
                ]);
                $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',13 )->first()->text);
            }


        }
        if ($inputAssign['cs'] =='0' && $inputAssign['spd']>1 && $lastAssign['spd']<1 ){
               Notification::create([
                'notification_text_id' =>14,
                'imei_id' => $imei->id,
                'seen' => '0'
            ]);

            $messageRes=FirebaseMessage::send($device_token,'Vesga GPS',NotificationText::where('id',14 )->first()->text);
        }
        return  [

            '$status' => 'success',
            '$data' => $messageRes,
            '$imei'=>$imei,
            '$last'=>$lastAssign,
            '$input'=>$inputAssign,
            '$users'=>$users,
            '$run'=>$run,
            '$tokens' => $device_token
        ];



    }
}
