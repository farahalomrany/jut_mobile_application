<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['sender_id', 'receiver_id','body','read_at'];
   
    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id','id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id','id');
    }

}
