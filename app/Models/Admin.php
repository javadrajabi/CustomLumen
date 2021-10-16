<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $level level
@property int $portalid portalid
@property varchar $name name
@property varchar $image image
@property varchar $user user
@property varchar $pass pass
@property varchar $lastlogin lastlogin
@property varchar $lastip lastip
@property int $badlogin badlogin
@property varchar $badlogintime badlogintime
@property longtext $levelaccess levelaccess
@property varchar $mobile mobile
@property varchar $smssend smssend
@property varchar $status status
   
 */
class Admin extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'admin';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'level',
'portalid',
'name',
'image',
'user',
'pass',
'lastlogin',
'lastip',
'badlogin',
'badlogintime',
'levelaccess',
'mobile',
'smssend',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}