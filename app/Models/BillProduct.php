<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class BillProduct extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['bill_id', 'product_id', 'size','amount','price',
                          ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class,'bill_id','id');
    }

}
