<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = ['filename', 'user_id', 'structure', 'created_at', 'updated_at'];
}
