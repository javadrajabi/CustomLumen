<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $sp_id sp id
@property varchar $type type
@property varchar $title title
@property varchar $pic pic
@property text $description description
@property int $portalid portalid
@property int $sort sort
@property varchar $status status
@property Portalid $setting belongsTo
   
 */
class Gallery extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'gallery';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'sp_id',
'type',
'title',
'pic',
'description',
'portalid',
'sort',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * portalid
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function portalid()
    {
        return $this->belongsTo(Setting::class,'portalid');
    }




}