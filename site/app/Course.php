<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Course extends Model
{

    public $timestamps = false;
    protected $notFoundMessage = 'The to do list resource could be found';

    protected $fillable = [
        'name',
        'user_id'
    ];
}
