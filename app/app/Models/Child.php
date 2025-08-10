<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserParent;

class Child extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'children';

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

    public function income() {
        return $this->hasMany(Income::class);
    }

    public function spend() {
        return $this->hasMany(Spending::class);
    }
    
    public function goal() {
        return $this->hasMany(Goal::class);
    }

    public function invite() {
        return $this->hasMany(Invite::class);
    }

    public function parent()
    {
        return $this->belongsTo(UserParent::class, 'parent_id');
    }
}
