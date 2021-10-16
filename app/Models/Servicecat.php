<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $pagename pagename
@property varchar $name name
@property varchar $type type
@property int $level level
@property text $description description
@property varchar $header header
@property varchar $image image
@property varchar $style style
@property varchar $keywords keywords
@property varchar $memtype memtype
@property int $portalid portalid
@property varchar $showinmenu showinmenu
@property varchar $showinhome showinhome
@property int $sort sort
@property varchar $status status
   
 */
class Servicecat extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'servicecat';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'code',
'pagename',
'name',
'type',
'level',
'description',
'header',
'image',
'style',
'keywords',
'memtype',
'portalid',
'showinmenu',
'showinhome',
'sort',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}