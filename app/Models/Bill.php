<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory, HasApiTokens;

  
    protected $fillable = ['member_id', 'bill_image','upload_date'];

    public function billproducts()
    {
        return $this->hasMany(BillProduct::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }


    public function products(){

        $products = Product::whereHas('billproducts', function ($q)  {
            $q->where('bill_id', $this->id );
        })->get();

        return $products;
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }

    public static function boot()
    {
       
        $class = static::class;
        parent::boot();
        static::updating(function($model)
        {
            $model->insert_date = Carbon::now();
            
        });
        
    }

    
 

}
