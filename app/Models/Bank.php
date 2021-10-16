<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $name name
@property varchar $logo logo
@property int $sort sort
@property varchar $status status
   
 */
class Bank extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'bank';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'code',
'name',
'logo',
'sort',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}