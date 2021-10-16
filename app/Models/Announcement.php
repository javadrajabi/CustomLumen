<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property tinyint unsigned $receive_type receive type
@property varchar $title title
@property text $description description
@property int $sp_id sp id
@property varchar $send_time send time
@property tinyint unsigned $send_sms send sms
@property tinyint unsigned $status status
   
 */
class Announcement extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'announcements';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'receive_type',
'title',
'description',
'sp_id',
'send_time',
'send_sms',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}