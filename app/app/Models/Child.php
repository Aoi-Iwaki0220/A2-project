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

    public function income() {
        return $this->hasMany('App\Models\Income');
    }

    public function spend() {
        return $this->hasMany('App\Models\Spending');
    }

    public function goal() {
        return $this->hasMany('App\Models\Goal');
    }

    public function invite() {
        return $this->hasMany('App\Models\Invite');
    }


}
