<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class CategoryInx extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "categories_inx";
    
    protected $fillable = ['name','image','description','parent'];

    public function products()
    {
        return $this->hasMany(Product::class,'category_id', 'id');
    }

    public function orderedproducts($id)
    {
        return $products = Product::orderBy('product_order','asc')->where('category_id',$id)->get();

        // return $this->hasMany(Product::class,'category_id', 'id');
    }

    public function is_parent(){

        $categoryInx = CategoryInx::where('parent',$this->id)->first();
        if($categoryInx){
            return true;
        }
        else{
            return false;
        }
         
    }
    

}
