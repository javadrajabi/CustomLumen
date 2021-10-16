<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property text $levelaccess levelaccess
@property varchar $status status
   
 */
class Admingroup extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'admingroup';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'name',
'levelaccess',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}