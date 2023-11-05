<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Favorite;
use App\Http\Resources\Favorites\FavoriteResource;
use App\Http\Resources\Products\ProductResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class FavoriteController extends BaseController
{

    public function favorite(Request $request)
    {
        
        $user_id = Auth()->user()->id;
       
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'product_id' => 'required|exists:products,id',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }
        
        $product_id = $input['product_id'];
           
        $favorite = Favorite::where('user_id', $user_id)->where('product_id', $product_id)->first();
        
        if($favorite){
           
            Favorite::where('user_id', $user_id)->where('product_id', $product_id)->delete();
            return $this->sendResponse([],'Product has removed from favorites successfully.');
        }
        else{
           
            $favorite = new Favorite();
          
            $favorite->user_id = $user_id;
            $favorite->product_id = $product_id;
            $favorite->save();
                
            return $this->sendResponse(new FavoriteResource($favorite),'Product added to favorites successfully.');
               
        }
        
        
    }

    public function getFavorites(){

        $user_id = Auth()->user()->id;
        $favorites = Favorite::where('user_id', $user_id)->get();
        $products = [];
        foreach($favorites as $favorite){
            if($favorite->product){

                $products[] = $favorite->product;
            }
            
        }
        if (isset($products)) {
            $data['products']    = ProductResource::collection($products);
            return $this->sendResponse($data, 'Favorited products retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }
}
