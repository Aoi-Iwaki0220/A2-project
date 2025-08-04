<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Child extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'children';

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
