<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function fromUser(){
        return $this->belongsTo(UserParent::class, 'from_user_id');
    }

    public function reads(){
        return $this->hasOne(MessageRead::class);
    }

    public function getReadInfoByUser($userId){
        if ($this->reads && $this->reads->user_id == $userId) {
            return $this->reads;
        }
        return null;
    }

    public function isReadByUser($userId){
         return $this->reads()->where('user_id', $userId)->exists();
    }
}
