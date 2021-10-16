<?php

namespace App\Models;


use App\Libraries\FilterQueryString\FilterQueryString;
use App\Models\Filters\MemberFilters;
use Illuminate\Database\Eloquent\Model;

/**
   @property int $sp_id sp id
@property varchar $code code
@property varchar $fname fname
@property varchar $lname lname
@property varchar $gender gender
@property varchar $job job
@property int $gradeid gradeid
@property varchar $father father
@property varchar $shsh shsh
@property varchar $birthloc birthloc
@property varchar $birthday birthday
@property varchar $codemeli codemeli
@property varchar $mobile mobile
@property varchar $tel tel
@property varchar $email email
@property varchar $image image
@property varchar $countrycode countrycode
@property varchar $ostancode ostancode
@property varchar $shahrestancode shahrestancode
@property varchar $address address
@property varchar $codeposti codeposti
@property varchar $activationcode activationcode
@property int $activationdate activationdate
@property int $activationsendcount activationsendcount
@property int $activationsendtime activationsendtime
@property varchar $moaref moaref
@property int $secquestionid secquestionid
@property varchar $secresponse secresponse
@property int $portalid portalid
@property varchar $device_id device id
@property tinyint $receive_notifications receive notifications
@property varchar $regdate regdate
@property varchar $status status
@property varchar $temp temp
@property Portalid $setting belongsTo
@property Gradeid $grade belongsTo
@property Sp $serviceProvider belongsTo

 */
class Member extends Model
{

    use FilterQueryString, MemberFilters;



    /**
     * Database table name
     */

    protected $table = 'members';
    public $timestamps = false;
    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'temp',
        'sp_id',
        'code',
        'fname',
        'lname',
        'gender',
        'job',
        'gradeid',
        'father',
        'shsh',
        'birthloc',
        'birthday',
        'codemeli',
        'mobile',
        'tel',
        'email',
        'image',
        'countrycode',
        'ostancode',
        'shahrestancode',
        'address',
        'codeposti',
        'activationcode',
        'activationdate',
        'activationsendcount',
        'activationsendtime',
        'moaref',
        'secquestionid',
        'secresponse',
        'portalid',
        'device_id',
        'receive_notifications',
        'regdate',
        'status',
        'temp'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * portalid
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function portalid()
    {
        return $this->belongsTo(Setting::class, 'portalid');
    }


    /**
     * sp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sp()
    {
        return $this->belongsTo(ServiceProvider::class, 'sp_id');
    }

}
