<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Products\ProductDetailResource;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    public function orderProducts(Request $request)
    {
            
            $input = $request->all();
            $validator = Validator::make($input, [
                'product_ids' => '',
            ]);
            if ($validator->fails()) {
                return $this->sendError([], $validator->errors());
            }
            
            $productIds = $input['product_ids'];
            $productIds = json_decode($productIds, true); 

            $products = [];

           if (is_array($productIds)) {
               if (isset($productIds[0])) {
                   foreach ($productIds as $key=>$productId) { 
                       if(Product::find($productId)){ 
                            $product = Product::where('id',$productId)->first();
                        
                            $product->product_order = $key +1;
                            $product->save();

                            $products[] = $product;
                          
                       }
                       else{
                           return $this->sendError([], " Product not exist");
                       }
                   }
               }
               else{
                   return $this->sendError([], "You didnt insert any product id");
               }
           }
           else{
               return $this->sendError([], "product_ids is not array");
           }
         
            $data['products'] = ProductResource::collection($products);

            return $this->sendResponse($data, 'products ordered successfully.');
    }

    //get all products with filter by[category_id]
    public function products(Request $request)
    {
       
        // $products = Product::where($request->filters)->get();
        $products = Product::orderBy('product_order','asc')->get();

        if(isset($request->filters['name'])){
            $name = $request->filters['name'];
            $products = Product::where('name','like',"%{$name}%")->get();
            
        }

        if(isset($request->filters['description'])){
            $description = $request->filters['description'];
            $products = Product::where('description','like',"%{$description}%")->get();
            
        }

        if(isset($request->filters['name']) && isset($request->filters['description'])){
            $description = $request->filters['description'];
            $name = $request->filters['name'];
            $products = Product::where('name','like',"%{$name}%")->where('description','like',"%{$description}%")->get();
            
        }
                
        if (isset($products)) {
            $data['products']    = ProductResource::collection($products);
            return $this->sendResponse($data, 'products retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

     //get product with its details
     public function productDetails($id)
     {
         
         $product = Product::where('id',request()->id)->first();
       
         if($product){
          
             return $this->sendResponse(new ProductDetailResource($product),'Product retrived with its details successfully.');
         }
         else {
             return $this->sendError([],"product not exist");
         }
     }

}
