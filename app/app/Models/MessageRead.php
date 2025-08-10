<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageRead extends Model
{
    use HasFactory;
    
    protected $table = 'message_reads';

    protected $fillable = [ 'message_id','user_id','read_at',];

    public function message(){
        return $this->belongsTo(Message::class);
    }
}
