<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['member_id', 'campaign_id','status','date'];

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'campaign_id','id');
    }

    public function gifts()
    {
         return $this->hasMany(Gift::class);
    }

}
