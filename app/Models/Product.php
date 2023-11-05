<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasApiTokens;
    public function save(array $options = [])
    {
        // Do whatever you want
        $this->size_price = json_encode(request()->input('size_price'));
        $this->related_products = json_encode(request()->input('related_products'));

        parent::save();
    }
    protected $fillable = ['name', 'category_id', 'image','size_price','brochure',
                          'is_new','is_super','related_products','description'];

    public function category()
    {
        return $this->belongsTo(CategoryInx::class, 'category_id', 'id');
    }

    public function billproducts()
    {
        return $this->hasMany(BillProduct::class);
    }

    public function campaignproducts()
    {
        return $this->hasMany(CampaignProduct::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // public function getSizePriceAttribute($value)
    // {
        
    //     if($value !== null){
    //         return json_decode($value);

    //     }
    //     return $value;

    
    // }

    // public function size_price_json($size_price)
    // {
    //     // $size_price = '{"0":{"price":"100","size":"m"},"01":{"price":"900","size":"s"}}';
    //     $details_string = "";
    //     // $string_array = [];
    //     // $count=0; for return array
    //     foreach (json_decode($size_price ,true) as $key => $value){
             
    //             $details_string = $details_string . "product size : {$value["size"]} , product price : {$value["price"]}   ";
    //             //for array return
    //             // $details_string = "product size : {$value["size"]} , product price : {$value["price"]}   ";

    //             // $string_array[$count] = $details_string;
    //             // $count ++;
              
    //     }
    //     //for array return
    //     // return $string_array;

    //     return $details_string;
    // }
    // public function getSizePriceAttribute()
    // {
    //     return $this->size_price_json($this->attributes['size_price']) ;
    // }
    // public function rel_product_json($product_id)
    // {
    //     // $product_id = '{"0":{"id":"100"},"01":{"id":"900"}}';
    //     $details_string = "";
    //     // $string_array = [];
    //     // $count=0; for return array
    //     foreach (json_decode($product_id ,true) as $key => $value){
             
    //             $details_string = $details_string . "product id : {$value["id"]}   ";
    //             //for array return
    //             // $details_string = "product id : {$value["id"]}   ";
    //             // $string_array[$count] = $details_string;
    //             // $count ++;
              
    //     }
    //     //for array return
    //     // return $string_array;

    //     return $details_string;
    // }
    // public function getRelatedProductsAttribute()
    // {
    //     return $this->rel_product_json($this->attributes['related_products']) ;
    // }

   
    // public function getSizePriceAttribute($value)
    // {
    //     if($value !== null){
    //         return json_encode($value);

    //     }
    //     return $value;
    // }
    
    public static function boot()
    {
       
        $class = static::class;
        parent::boot();
        static::updating(function($model)
        {
            // if($model->product_order !== null){
            //     dd($model->product_order);
            // }
            // dd($model->related_products);
            // $model->related_products = json_encode($model->related_products);
            // $model->save();
            // $rel = json_decode($model->related_products);
            
            // if($model->related_products == "[{\"id\":null}]"){
               
            //     $model->related_products = null;
            //     dd($model->related_products);
            //     $model->save();
            //     dd($model);
            // }
        });
    }

}
