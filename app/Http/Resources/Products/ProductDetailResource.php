<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        // $language = $request->header('Accept-Language');
        // $name =   $this->getTranslatedAttribute('name', $language , 'en');

        $image = "#";
       
        $brochure = [];
        $description = "";
        $size = "";
        $price = "";
        $sizesprices = [];
        $finalmages = [] ;
        $finalbrochures = [];
       
        if($this->image !== null ){
           
            $images = json_decode($this->image, true);
            if(count($images) > 0){
            
                foreach($images as $image){
                    $finalmages[] = url('storage').'/'.$image;
                }
                $image = $finalmages;
                    
            }
        }

        if($this->brochure !== null){
            $brochures = json_decode($this->brochure, true);
            if(count($brochures) > 0){
                foreach($brochures as $brochure){
                    $finalbrochure['link'] = url('storage').'/'.$brochure['download_link'];
                    $finalbrochure['name'] = $brochure['original_name'];
                    $finalbrochures[]=$finalbrochure;
                }
                $brochure = $finalbrochures;
            }
        }

        if($this->description !== null){
            $description = $this->description;
        }

        if($this->size_price !== null){
            
            $sizesprices = json_decode($this->size_price, true);
        }
       

        $related_products = [];
        if($this->related_products !== "null"){
            
            $relatedproducts = json_decode($this->related_products, true);
            foreach($relatedproducts as $relatedproduct){
                
                $id = $relatedproduct['id'];
                
                    $product = Product::where('id',$id)->first();
                    if($product && $product->id !== $this->id){
                        $related_products[] = $product;
                        
                    }   
            }
        }
 

        $isFavorite = null;
        if($request->header('Authorization')){
            $token =  PersonalAccessToken::findToken($request->header('Authorization'));
            $user = $token?$token->tokenable:null;
            if($user){
                $favorite = Favorite::where('user_id',$user->id)->where('product_id',$this->id)->first();
                if($favorite){
                    $isFavorite = true;
                }
                else{
                    $isFavorite = false;
                }
            }
            else{
                $isFavorite = null; 
            }
        }
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'category_id' => $this->category_id ,
            'brochure' => $brochure,
            'is_new' => $this->is_new,
            'is_super' => $this->is_super,
            'isFavorite' => $isFavorite,
            'description' => $description,
            'available_sizes_and_prices' => $sizesprices,
            'related_products' => ProductWithoutRelatedProductsResource::collection($related_products), //array of products
           
        ];
    }
}
