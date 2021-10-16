<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $cat cat
@property varchar $name name
@property varchar $path path
@property varchar $page page
@property int $sort sort
@property varchar $icon icon
@property text $description description
@property varchar $extraparam extraparam
@property varchar $showinmenu showinmenu
@property varchar $status status
   
 */
class AdminLevellist extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'admin_levellist';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'cat',
'name',
'path',
'page',
'sort',
'icon',
'description',
'extraparam',
'showinmenu',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}