<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $countrycode countrycode
@property varchar $name name
@property int $sort sort
@property varchar $status status
@property Countrycode $country belongsTo
@property \Illuminate\Database\Eloquent\Collection $shahrestan hasMany
   
 */
class Ostan extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'ostan';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'code',
'countrycode',
'name',
'sort',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * countrycode
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function countrycode()
    {
        return $this->belongsTo(Country::class,'countrycode');
    }

    /**
    * shahrestans
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function shahrestans()
    {
        return $this->hasMany(Shahrestan::class,'ostancode');
    }



}