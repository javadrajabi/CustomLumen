<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $price price
@property varchar $type type
@property varchar $description description
@property varchar $userid userid
@property varchar $paymentid paymentid
@property varchar $orderid orderid
@property varchar $createdate createdate
@property varchar $updatedate updatedate
@property varchar $status status
   
 */
class Transaction extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'transaction';

    /**
    * Mass assignable columns
    */
    protected $fillable=['status',
'price',
'type',
'description',
'userid',
'paymentid',
'orderid',
'createdate',
'updatedate',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}