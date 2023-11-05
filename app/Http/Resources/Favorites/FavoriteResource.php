<?php

namespace App\Http\Resources\Favorites;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
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

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
        ];
    }
}
