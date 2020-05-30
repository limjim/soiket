<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 's_accounts';

    protected $fillable = ['full_name', 'uid', 'image', 'auth_code', 'user_id'];
}
