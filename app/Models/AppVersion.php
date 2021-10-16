<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $name name
@property tinyint unsigned $app_type app type
@property varchar $version version
@property tinyint $mandatory mandatory
@property varchar $download_src download src
@property varchar $created_at created at
@property varchar $modified_at modified at
@property text $description description
@property tinyint unsigned $status status
   
 */
class AppVersion extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'app_versions';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'name',
'app_type',
'version',
'mandatory',
'download_src',
'modified_at',
'description',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}