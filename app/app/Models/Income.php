<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Type;

class Income extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function type() {
        return $this->belongsTo(Type::class); 
        }

    public function child(){
        return $this->belongsTo(Child::class, 'user_id');
    }
}
