<?php
require_once('jdf.php');
require_once('safeval.php');

function CleanUp()
{
  exit;
}

function crypto_rand_secure($min, $max)
{
  $range = $max - $min;
  if ($range < 1) return $min; // not so random...
  $log = ceil(log($range, 2));
  $bytes = (int)($log / 8) + 1; // length in bytes
  $bits = (int)$log + 1; // length in bits
  $filter = (int)(1 << $bits) - 1; // set all lower bits to 1
  do {
    $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
    $rnd = $rnd & $filter; // discard irrelevant bits
  } while ($rnd > $range);
  return $min + $rnd;
}

function getToken($length)
{
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet .= "0123456789";
  //$codeAlphabet.="!@#$%^&*";
  $max = strlen($codeAlphabet); // edited

  for ($i = 0; $i < $length; $i++) {
    $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
  }

  return $token;
}

function isSetAndNotNull($_Value)
{
  return isset($_Value) && !is_null($_Value);
}

function OffsetAndLimitArray($_Data)
{
  include(BASE_DIR . '/lib/classes/config.php');

  $_Offset = 0;
  $_Limit = $_Config['LIST_LIMIT'];

  if (isSetAndNotNull($_Data['limit'])) {
    $_Limit = $_Data['limit'];
  }
  if (isSetAndNotNull($_Data['page'])) {
    $_Offset = ($_Data['page'] - 1) * $_Limit;
  }

  return [$_Offset, $_Limit];
}

function FileExtensionFromB64($File)
{
  if ($File) {
    return explode('/', explode(';', $File)[0])[1];
  } else {
    return false;
  }
}

function ExtractFile($File)
{
  if ($File) {
    return explode(',', explode(';', $File)[1])[1];
  } else {
    return false;
  }
}

function IsBase64($File)
{
  if ($File) {
    $Parts = explode(';', $File);

    if (explode(',', $Parts[1])[0] === 'base64') {
      return true;
    } else {
      return false;
    }
  } else {
    return true;
  }
}

function DeleteFile($File, $Path)
{
  if (file_exists($Path . '/' . $File)) {
    unlink($Path . '/' . $File);
  }
  return;
}

function UploadFile($File, $Path = './', $FileName = null, $AllowedExtensions = null)
{
  if ($File) {
    if ($File === 'delete') {
      DeleteFile($FileName, $Path);
      return [
        'success' => true,
        'file' => null
      ];
    } elseif (IsBase64($File)) {
      $Extension = FileExtensionFromB64($File);
      if (empty($AllowedExtensions) || array_search($Extension, $AllowedExtensions)) {

        $File = base64_decode(ExtractFile($File));
        if ($File === false) {
          return [
            'success' => false,
            'err' => 'فرمت فایل نادرست است'
          ];
        }
        $RandomNumber = rand(11111, 99999);
        $FileName = time() . "_{$RandomNumber}.{$Extension}";
        @mkdir($Path, 0755, true);
        $FilePath = "{$Path}/{$FileName}";

        file_put_contents($FilePath, $File);
        return [
          'success' => true,
          'file' => $FileName
        ];
      } else {
        return [
          'success' => false,
          'err' => 'فرمت فایل نادرست است'
        ];
      }
    } elseif ($FileName) {
      return [
        'success' => true,
        'file' => $FileName
      ];
    } else {
      return [
        'success' => false,
        'err' => 'فرمت فایل نادرست است'
      ];
    }
  } else {
    return [
      'success' => true,
      'file' => $FileName
    ];
  }
}


function ins_log($ip, $attempts, $successful, $text, $device, $os)
{


  if ($text == 'attempts') {
    $insert_log = array(
      "ip" => $ip,
      "datetime" => time(),
      "attempts" => "$attempts" + 1,
      "device" => $device,
      "successful" => "0"
    );
    if ($os != '') {
      $insert_log['os'] = $os;
    }
  } else if ($text == 'successful') {
      $insert_log = array(
          "ip" => $ip,
          "datetime" => time(),
          "attempts" => "0",
          "successful" => "1",
          "device" => "$device"
      );
      if ($os != '') {
          $insert_log['os'] = $os;
      }
  }
  \App\Models\AppLoginLog::create($insert_log);
//  $log_ban = $db->insert('app_login_log', $insert_log);

//  return;
}


/////////////////////////////////////////////////////////////////
function send($text, $player_id, $type, $type_user = 1)
{
  include(BASE_DIR . '/lib/classes/config.php');
  $player_id = is_array($player_id) ? $player_id : array($player_id);
  if ($type_user == 3) {
    $fields = array(
      'app_id' => $_Config['app_id'],
      'player_ids' => $player_id,
      'message' => $text
    );
  } else if ($type == 1) {
    $fields = array(
      'app_id' => $_Config['app_id'],
      'player_ids' => $player_id,
      'message' => $text
    );
  } else if ($type == 2) {
    $fields = array(
      'app_id' => $_Config['app_id_sp'],
      'player_ids' => $player_id,
      'message' => $text
    );
  }

  $fields = json_encode($fields);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://citify.ir/OneSignal_Notification.php");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

  $response = curl_exec($ch);

  curl_close($ch);
  $response = json_decode($response, true);

  if (is_null($response['errors'][0]))
    return true;
  else
    return false;
}


//////////////////////////////////////////////////////
function sendNotification($db, $userss, $text, $receiver, $user_type_tkn, $receiver_type, $subject, $type = 0)
{
  $text = $text;
  $type_user = 1;



  if (isset($userss) and ($userss != '')) {
    $users = explode(',', $userss);

    foreach ($users as $u) {
      $db->where("id", $u);
      $db->where("status", 1);
      if ($user_type_tkn == 1) {
        $row_Rsdevice = $db->getOne("members", ["device_id", "receive_notifications"]);
      } else if ($user_type_tkn == 2) {
        $row_Rsdevice = $db->getOne("service_providers", ["device_id", "receive_notifications"]);
      }
      if ($type == 3) {
        $type_user = 3;
        $row_Rsdevice = $db->where("id", $receiver)->getOne("members", ["device_id", "receive_notifications"]);
      }
      if ($type == 4) {
        $type_user = 4;
        $row_Rsdevice = $db->where("id", $receiver)->getOne("service_providers", ["device_id", "receive_notifications"]);
      }
      if ($type == 2) {
        if ($receiver_type == 1) {
          $type_user = 3;
          $row_Rsdevice = $db->where("id", $receiver)->getOne("members", ["device_id", "receive_notifications"]);
        } else if ($receiver_type == 2) {
          $type_user = 4;
          $row_Rsdevice = $db->where("id", $receiver)->getOne("service_providers", ["device_id", "receive_notifications"]);
        }
      }
      //
      if ($row_Rsdevice['device_id']) {
        $device_id = $row_Rsdevice['device_id'];
        if ($row_Rsdevice['receive_notifications']) {
          send($text, $device_id, $user_type_tkn, $type_user);
        }
        $arr_up = [
          'sender' => $u,
          'receiver' => $receiver,
          'sender_type' => $user_type_tkn,
          'receiver_type' => $receiver_type,
          'subject' => $subject,
          'details' => $text,
          'is_read' => 0,
          'created_at' => jdate("Y/m/d H:i:s"),
          'updated_at' => jdate("Y/m/d H:i:s"),
          'status' => 0
        ];
        $result = $db->insert("notifications", $arr_up);
      }
    }
    return 1;
  }
  return 0;
}

function SaveAndSendNotification($Sender, $SenderType, $Receivers, $Receiver_Type, $Subject, $Message)
{
  global $db;
  if (count($Receivers)) {
    $ReceiversInfo = $db->where("id", $Receivers, "IN")
      ->where("receive_notifications", 1)
      ->where("device_id IS NOT NULL")
      ->get("members", null, ["device_id", 'id']);

    $Devices = array_unique(array_column($ReceiversInfo, 'device_id'));
    $ReceiverIDs = array_unique(array_column($ReceiversInfo, 'id'));

    send($Message, $Devices, $Receiver_Type);

    $data = array();

    foreach ($ReceiverIDs as $ReceiverID) {
      array_push($data, [
        $Sender, $SenderType, $ReceiverID, $Receiver_Type, $Subject, $Message, 0, jdate("Y/m/d H:i:s"), jdate("Y/m/d H:i:s"), 1
      ]);
    }
    $keys = array("sender", "sender_type", "receiver", "receiver_type", "subject", "details", "is_read", "created_at", "updated_at", "status");

    $db->insertMulti('notifications', $data, $keys);
  }
}
/////////////////////////////////////////////////////////////
function IsParamSent($Param)
{
  if (isset($Param) && !is_null($Param)) {
    return true;
  }
  return false;
}

function getBase64ImageSize($base64Image)
{ //return memory size in B, KB, MB
  try {
    $size_in_bytes = (int)(strlen(rtrim($base64Image, '=')) * 3 / 4);
    $size_in_kb = $size_in_bytes / 1024;
    $size_in_mb = $size_in_kb / 1024;

    return $size_in_mb;
  } catch (Exception $e) {
    return $e;
  }
}
///////////////////////////////////////////////////////////////
function CheckPWSafety($PW, $MinChars = 0, $Type = 0)
{
  /*
  Types:
  	1: At least 1 letter and 1 number
  */

  if ($MinChars) {
    if (strlen($PW) < $MinChars) {
      return false;
    }
  }

  if ($Type) {
    switch ($Type) {
      case '1':
        if (!preg_match('/[A-Za-z]/', $PW) || !preg_match('/[0-9]/', $PW)) {
          return false;
        }
        break;
      default:
        return false;
    }
  }
  return true;
}

function PrepareQuery($db = null, $Data = [], $FilterableFields = [], $SearchableFields = [])
{
  if (!$db) {
    return;
  }
  $RequestFields = $Data['filter'] ? $Data['filter'] : [];
  $SearchParam = $Data['search'] ? $Data['search'] : [];

  foreach ($FilterableFields as $key => $FieldName) {
    if (isset($RequestFields[$FieldName]) && !is_null($RequestFields[$FieldName])) {
      $db->where($FieldName, $RequestFields[$FieldName]);
    }
  }

  if (!empty($SearchableFields) && $SearchParam) {
    $_Condition = "";
    foreach ($SearchableFields as $key => $FieldName) {
      $_Condition .= " OR $FieldName LIKE ? ";
    }
    $_Condition = $_Condition ? "(" . ltrim($_Condition, " OR") . ")" : $_Condition;
    $db->where($_Condition, array_fill(0, count($SearchableFields), '%' . $SearchParam . '%'));
  }

  $_CountQuery = $db->copy();

  if (isSetAndNotNull($Data['order'])) {
    $db->orderBy($Data['order'], $Data['ordertype'] === 'ASC' ?  'ASC' : 'DESC');
  }

  return $_CountQuery;
}

function GetParent($ID)
{
  global $db;

  $ThisUserInfo = $db->where('id', $ID)
    ->getOne('service_providers', '*');

  if ($ThisUserInfo['parent_id']) {
    $ParentInfo = $db->where('id', $ThisUserInfo['parent_id'])
      ->getOne('service_providers', '*');
    return ($ParentInfo);
  } else {
    return $ThisUserInfo;
  }
}

function GetSubs($ID)
{
  global $db;

  $Subs = $db->where('parent_id', $ID)
    ->get('service_providers', null, '*');

  return $Subs;
}

function UpdateZarfiyatReserves($ZarfiyatID)
{
  global $db;

  $db->rawQueryOne("UPDATE zarfiyat LEFT JOIN (SELECT zarfiyat_id, COUNT(*) as count FROM reserve WHERE status IN (1,6) GROUP BY zarfiyat_id) reserve ON zarfiyat_id = zarfiyat.id SET reserved = count WHERE id = ?", [$ZarfiyatID]);

  return;
}
/////////////////////////////////////////////////
function shift_name($value)
{
  if ($value == 1) {
    return 'صبح';
  } else if ($value == 2) {
    return 'عصر';
  } else if ($value == 3) {
    return 'شب';
  }
}
/////////////////////////////////////////////////
function appointment_type($value)
{
  if ($value == 1) {
    return 'نیاز به تایید';
  } else if ($value == 2) {
    return 'اتوماتیک';
  }
}
/////////////////////////////////////////////////
function attendance_status($value)
{
  if ($value == 0) {
    return ' نامشخص';
  } else if ($value == 1) {
    return 'حضور';
  } else if ($value == 2) {
    return 'عدم حضور';
  }
}
/////////////////////////////////////////////////
function reserve_status($value)
{
  if ($value == 1) {
    return '  تایید شده';
  } else if ($value == 4) {
    return 'رد شده';
  } else if ($value == 6) {
    return 'در انتظار تایید';
  }
}
