<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class CityInx extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $table = "cities_inx";
    
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class,'city_id', 'id');
    }

}
