<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\CategoryInx;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Products\ProductDetailResource;
use App\Http\Resources\Categories\CategoryDetailResource;
use App\Http\Resources\Categories\CategoryDetailAllTreeResource;

class CategoryController extends BaseController
{

    //get all categories with filter by[id]
    public function categories(){
       
        $categories = CategoryInx::where('parent',-1)->get();

        if(request()->id){
            $categories = $categories->where('id','=',request()->id);
        
        }
        if (isset($categories)) {
            $data['categories']    = CategoryResource::collection($categories);
            return $this->sendResponse($data, 'Categories retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

    //get category with its details
    public function categoryDetails($id)
    {
        $category = CategoryInx::where('id',$id)->first();
        if($category->is_parent()){

            $categories = CategoryInx::where('parent',$id)->get();

            if (isset($categories)) {
                $data['categories']    = CategoryDetailResource::collection($categories);
                return $this->sendResponse($data, 'Categories retrived successfully.');
            } 
            // else {
            //     return $this->sendError([],"error");
            // }

        }
        else{
            return $this->sendResponse(new CategoryDetailResource($category), 'Categories retrived successfully.');
        }

       
    }

    public function categoryDetailAllTree($id)
    {
        $categories = CategoryInx::where('parent',$id)->get();

        if (isset($categories)) {
            $data['categories']    = CategoryDetailAllTreeResource::collection($categories);
            return $this->sendResponse($data, 'Categories retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

    //get category with its details for tree
    public function categoryDetailsForTree($id)
    {
       
        $category = CategoryInx::where('id',$id)->first();

        if ($category) {
            $products = $category->products;
            $data['products']    = ProductDetailResource::collection($products);
            return $this->sendResponse($data, 'Products retrived successfully.');
        } 
        else {
            return $this->sendError([],"category not exist");
        }
    }

}
