<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserParent extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'parents';

     protected $fillable = [
        'name',
        'nickname',
        'mailaddress',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
