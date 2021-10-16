<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name_fa name fa
@property varchar $name_en name en
@property tinyint unsigned $status status
   
 */
class DaysOfWeek extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'days_of_week';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'name_fa',
'name_en',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}