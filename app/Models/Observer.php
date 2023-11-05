<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Observer extends Model
{
    use HasFactory, HasApiTokens;

    protected $morphClass = 'observer';


    public function user()
    {
      return $this->morphOne(User::class, 'userable');
    }

    public function distributorObservers()
    {
        return $this->hasMany(DistributorObserver::class,'observer_id', 'id');
    }

    public function distributores(){

      $distributores = Distributor::whereHas('distributorObservers', function ($q)  {
          $q->where('observer_id', $this->id );
      })->orderBy('id', 'desc')->get();

      return $distributores;
  }

}
