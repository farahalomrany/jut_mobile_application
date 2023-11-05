<?php

namespace App\Http\Resources\Campaigns;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignProductResource extends JsonResource
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
      
        $pointss = [];
       
        if($this->points !== null){
            
            $points[] = json_decode($this->points, true);
        }

        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'points' => $points,
           
        ];
    }
}
