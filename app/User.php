<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * @content String name, String email, String password, Integer supervisor_id, String photo, Bool old, Bool isStudent.
     */

    protected $fillable = [
        'name', 'email', 'password', 'supervisor_id', 'photo', 'old', 'isStudent',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     * @content String password, remember_token
     */

    protected $hidden = [
        'password', 'remember_token',
    ];
}
