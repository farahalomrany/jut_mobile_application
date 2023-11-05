<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Products\ProductWithoutRelatedProductsResource;
use App\Http\Resources\Products\ProductResource;
use App\Models\CategoryInx;

class CategoryDetailResource extends JsonResource
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
        
        if($this->image !== null){
            $image = $image = url('storage').'/'.$this->image;
        }

        $products = $this->orderedproducts($this->id);

        $is_final = 0;

        $category = CategoryInx::where('id',$this->id)->first();

        $is_parent = $category->is_parent();

        if($is_parent){
            $is_final = 0;
        }
        else{
            $is_final = 1;
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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'description' => $this->description,
            'is_final' => $is_final,
            'products' =>  ProductResource::collection($products),
        ];
    }
}
