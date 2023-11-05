<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Products\ProductWithoutRelatedProductsResource;
use App\Http\Resources\Products\ProductDetailResource;
use App\Models\CategoryInx;

class CategoryDetailAllTreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        $image = "#";

        if($this->image !== null){
            $image = $image = url('storage').'/'.$this->image;
        }

        
        $categories = CategoryInx::where('parent',$this->id)->get();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'description' => $this->description,
            'sub_categories' =>  CategoryDetailAllTreeResource::collection($categories),
        ];
    }
}
