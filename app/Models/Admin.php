<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory, HasApiTokens;

    protected $morphClass = 'admin';
 

    public function user()
    {
      return $this->morphOne(User::class, 'userable');
    }

}
