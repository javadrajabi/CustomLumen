<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $sp_id sp id
@property varchar $service_id service id
@property tinyint unsigned $shift shift
@property varchar $set_date set date
@property varchar $date date
@property int unsigned $zarfiyat zarfiyat
@property int unsigned $reserved reserved
@property varchar $wait_time wait time
@property varchar $starttime starttime
@property varchar $endtime endtime
@property tinyint unsigned $status status
   
 */
class Zarfiyat extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'zarfiyat';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'sp_id',
'service_id',
'shift',
'set_date',
'date',
'zarfiyat',
'reserved',
'wait_time',
'starttime',
'endtime',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}