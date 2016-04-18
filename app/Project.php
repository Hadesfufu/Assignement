<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * @package App
 */
class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * @content String name, Integer creatorId, String description, Bool old
     */
    protected $fillable = [
        'name', 'creatorId', 'description', 'old',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     * @content String password, remember_token
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
