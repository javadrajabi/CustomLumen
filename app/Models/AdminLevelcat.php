<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property varchar $style style
@property varchar $image image
@property int $sort sort
@property varchar $status status
   
 */
class AdminLevelcat extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'admin_levelcat';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'name',
'style',
'image',
'sort',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}