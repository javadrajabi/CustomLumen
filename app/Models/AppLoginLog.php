<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $device device
@property varchar $ip ip
@property tinyint unsigned $os os
@property varchar $datetime datetime
@property tinyint $successful successful
@property smallint unsigned $attempts attempts

 */
class AppLoginLog extends Model
{

    /**
    * Database table name
    */
    protected $table = 'app_login_log';
    public $timestamps = false;
    /**
    * Mass assignable columns
    */
    protected $fillable=['attempts',
'device',
'ip',
'os',
'datetime',
'successful',
'attempts'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
