<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Child;
use App\Models\UserParent;

class Invite extends Model
{
    use HasFactory;
    public function child(){
        return $this->belongsTo(Child::class, 'child_id');
    }
}
