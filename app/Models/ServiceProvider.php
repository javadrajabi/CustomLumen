<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property int $parent_id parent id
@property varchar $user user
@property varchar $pass pass
@property varchar $name name
@property tinyint unsigned $appointment_type appointment type
@property varchar $ostan ostan
@property varchar $shahrestan shahrestan
@property varchar $shift_sobh shift sobh
@property varchar $shift_asr shift asr
@property varchar $shift_shab shift shab
@property varchar $image image
@property varchar $scatids scatids
@property varchar $sids sids
@property varchar $mobile mobile
@property varchar $tell tell
@property text $address address
@property varchar $latitude latitude
@property varchar $longitude longitude
@property tinyint unsigned $plan_type plan type
@property varchar $about_us_text about us text
@property varchar $invite_friends_text invite friends text
@property varchar $welcome_message welcome message
@property varchar $app_name app name
@property varchar $logo logo
@property varchar $website website
@property varchar $telegram telegram
@property varchar $instagram instagram
@property text $description description
@property varchar $setdate setdate
@property int $portalid portalid
@property varchar $device_id device id
@property tinyint $receive_notifications receive notifications
@property varchar $status status
@property varchar $temp temp
@property \Illuminate\Database\Eloquent\Collection $member hasMany
   
 */
class ServiceProvider extends Model 
{
    
    /**
    * Database table name
    */
    protected $table = 'service_providers';

    /**
    * Mass assignable columns
    */
    protected $fillable=['temp',
'parent_id',
'user',
'pass',
'name',
'appointment_type',
'ostan',
'shahrestan',
'shift_sobh',
'shift_asr',
'shift_shab',
'image',
'scatids',
'sids',
'mobile',
'tell',
'address',
'latitude',
'longitude',
'plan_type',
'about_us_text',
'invite_friends_text',
'welcome_message',
'app_name',
'logo',
'website',
'telegram',
'instagram',
'description',
'setdate',
'portalid',
'device_id',
'receive_notifications',
'status',
'temp'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * members
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function members()
    {
        return $this->hasMany(Member::class,'sp_id');
    }



}