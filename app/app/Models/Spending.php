<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Child;

class Spending extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function type() {
        return $this->belongsTo('App\Models\Type', 'type_id', 'id');    
        }

    public function user(){
        return $this->belongsTo(Child::class);
    }
}
