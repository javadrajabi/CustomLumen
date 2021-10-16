<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property tinyint unsigned $user_type user type
@property varchar $user_id user id
@property int $zarfiyat_id zarfiyat id
@property varchar $code code
@property varchar $time time
@property varchar $selected_service_id selected service id
@property tinyint unsigned $type type
@property text $description description
@property varchar $image image
@property varchar $req_date req date
@property varchar $confirm_date confirm date
@property int $transaction_id transaction id
@property tinyint unsigned $attendance_status attendance status
@property varchar $attendance_date attendance date
@property tinyint unsigned $status status
   
 */
class Reserve extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'reserve';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'user_type',
'user_id',
'zarfiyat_id',
'code',
'time',
'selected_service_id',
'type',
'description',
'image',
'req_date',
'confirm_date',
'transaction_id',
'attendance_status',
'attendance_date',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}