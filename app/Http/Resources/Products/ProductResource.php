<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Favorite;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class ProductResource extends JsonResource
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

        if($this->image !== null){
            $images = json_decode($this->image, true);
            if(count($images) > 0){
                $image = $image = url('storage').'/'.$images[0];
                    
            }
           
        }

        $description = "";
        if($this->description !== null){
            $description = $this->description;
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

        // $token = $request->header('Authorization');
        // $token = substr($token, strpos($token, "Bearer") + 7); 
        // $isFavorite = null;
        // if($token){
        //     $user = User::where('remember_token',$token)->first();
            
        //     if($user){
        //         $favorite = Favorite::where('user_id',$user->id)->where('product_id',$this->id)->first();
        //         if($favorite){
        //             $isFavorite = true;
        //         }
        //         else{
        //             $isFavorite = false;
        //         }
        //     }
           
        // }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'is_new' => $this->is_new,
            'is_super' => $this->is_super,
            'isFavorite' => $isFavorite,
            'category_id ' => $this->category_id ,
            'description ' => $description ,
            // 'order' => $this->product_order,
           
        ];
    }
}
