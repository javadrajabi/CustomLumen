<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property int $user_type_id
 * @property int $state
 * @property string|null $photo_url
 * @property string|null $name
 * @property string|null $mobile
 * @property string|null $comment
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property UserType $user_type
 * @property Collection|DeviceAccess[] $device_accesses
 * @property Collection|Imei[] $imeis
 *
 * @package App\Models
 */

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	protected $table = 'users';

	protected $casts = [
		'user_type_id' => 'int'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'user_type_id',
		'photo_url',
		'name',
		'mobile',
		'comment',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'device_token',
        'state'
	];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

	public function user_type()
	{
		return $this->belongsTo(UserType::class);
	}

	public function device_accesses()
	{
		return $this->hasMany(DeviceAccess::class, 'imei_id');
	}

	public function imeis()
	{
		return $this->hasMany(Imei::class, 'owner_id');
	}
}
