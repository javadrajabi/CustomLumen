<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $code code
@property varchar $countrycode countrycode
@property varchar $ostancode ostancode
@property varchar $name name
@property int $sort sort
@property varchar $status status
@property Ostancode $ostan belongsTo
@property Countrycode $country belongsTo
   
 */
class Shahrestan extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'shahrestan';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'code',
'countrycode',
'ostancode',
'name',
'sort',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * ostancode
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function ostancode()
    {
        return $this->belongsTo(Ostan::class,'ostancode');
    }

    /**
    * countrycode
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function countrycode()
    {
        return $this->belongsTo(Country::class,'countrycode');
    }




}