<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersAuthCodes extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'users_auth_codes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile',
        'code',
        'hash',
        'created_at',
    ];
}
