<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = ['name','address'];

    protected $morphClass = 'distributor';


    public function user()
    {
      return $this->morphOne(User::class, 'userable');
    }

    public function distributorObservers()
    {
        return $this->hasMany(DistributorObserver::class,'disrtibutor_id', 'id');
    }

}
