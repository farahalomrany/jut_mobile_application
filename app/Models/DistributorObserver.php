<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class DistributorObserver extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['disrtibutor_id', 'observer_id'];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class,'disrtibutor_id','id');
    }

    public function observer()
    {
        return $this->belongsTo(Observer::class,'observer_id','id');
    }

}
