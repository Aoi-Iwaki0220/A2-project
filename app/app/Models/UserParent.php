<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Child;


class UserParent extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'parents';

     protected $fillable = [
        'name',
        'nickname',
        'profile',
        'image',
        'mailaddress',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getEmailAttribute()
    {
        return $this->mailaddress;
    }

    public function getEmailForPasswordReset()
    {
        return $this->mailaddress;
    }

    public function child()
    {
        return $this->hasOne(Child::class, 'parent_id');
    }
}
