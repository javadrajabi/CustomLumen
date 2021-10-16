<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $sender_user_id sender user id
@property int $receiver_user_id receiver user id
@property tinyint unsigned $sender_type sender type
@property tinyint unsigned $receiver_type receiver type
@property varchar $subject subject
@property text $message message
@property tinyint $is_read is read
@property varchar $created_at created at
@property varchar $updated_at updated at
@property int $parent_id parent id
   
 */
class Message extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'message';

    /**
    * Mass assignable columns
    */
    protected $fillable=['parent_id',
'sender_user_id',
'receiver_user_id',
'sender_type',
'receiver_type',
'subject',
'message',
'is_read',
'parent_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}