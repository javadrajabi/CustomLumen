<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $website website
@property varchar $number number
@property varchar $username username
@property varchar $password password
@property tinyint unsigned $status status
   
 */
class SmsPanel extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'sms_panels';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'website',
'number',
'username',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}