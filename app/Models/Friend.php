<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 's_friends';

    protected $fillable = ['full_name', 'api_id', 'gender', 'avatar'];
}
