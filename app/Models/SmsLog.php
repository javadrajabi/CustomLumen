<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $sp_id sp id
@property int $member_id member id
@property varchar $send_time send time
@property varchar $text text
@property tinyint unsigned $status status
@property int unsigned $sms_panel_id sms panel id

 */
class SmsLog extends Model
{
    public $timestamps = false;
    /**
    * Database table name
    */
    protected $table = 'sms_log';

    /**
    * Mass assignable columns
    */
    protected $fillable=['sms_panel_id',
'sp_id',
'member_id',
'send_time',
'text',
'status',
'sms_panel_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
