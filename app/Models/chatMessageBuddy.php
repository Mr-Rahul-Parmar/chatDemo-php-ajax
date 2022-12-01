<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatMessageBuddy extends Model
{
    use HasFactory;

    protected $fillable = ['to_user_id','from_user_id','chat_message','attachment','status'];

    protected $dates = ['created_at','created_at'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

}
