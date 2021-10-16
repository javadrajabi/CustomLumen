<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id user id
 * @property tinyint unsigned $user_type user type
 * @property varchar $issued_in issued in
 * @property varchar $expires_in expires in
 * @property varchar $token_access token access
 * @property varchar $status status
 */
class UserToken extends Model
{

    public $timestamps = false;
    /**
     * Database table name
     */
    protected $table = 'user_token';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['status',
        'user_id',
        'user_type',
        'issued_in',
        'expires_in',
        'token_access',
        'status'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
