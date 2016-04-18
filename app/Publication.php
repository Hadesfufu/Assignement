<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Publication
 * @package App
 */
class Publication extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * @content String name, String content, String pdf, String txt, bool old
     */
    protected $fillable = [
        'name','content', 'pdf', 'txt', 'old',
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
