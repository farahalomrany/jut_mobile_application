<?php

namespace App\Http\Resources\GiftsNamesInx;

use Illuminate\Http\Resources\Json\JsonResource;

class GiftsNamesInxResource extends JsonResource
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
            $image = $image = url('storage').'/'.$this->image;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'description' => $this->description,
           
        ];
    }
}
