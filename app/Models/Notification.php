<?php
namespace App\Models;

use App\Libraries\FilterQueryString\FilterQueryString;
use App\Models\Filters\NotificationFilter;
use Illuminate\Database\Eloquent\Model;
/**
   @property int $sender sender
@property int $receiver receiver
@property tinyint $sender_type sender type
@property tinyint $receiver_type receiver type
@property varchar $subject subject
@property mediumtext $details details
@property tinyint $is_read is read
@property tinyint $status status
@property varchar $created_at created at
@property varchar $updated_at updated at

 */
class Notification extends Model
{
    use FilterQueryString, NotificationFilter;
    /**
    * Database table name
    */
    protected $table = 'notifications';

    /**
    * Mass assignable columns
    */
    protected $fillable=['sender',
'receiver',
'sender_type',
'receiver_type',
'subject',
'details',
'is_read',
'status'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}
