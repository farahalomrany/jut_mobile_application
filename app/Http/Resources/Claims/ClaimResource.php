<?php

namespace App\Http\Resources\Claims;

use Illuminate\Http\Resources\Json\JsonResource;

class ClaimResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        return [
            'id' => $this->id,
            'campaign_id' => $this->campaign_id , 
            'member_id' => $this->member_id , 
            'date' => $this->date ,  
            'status' => $this->status ,  
        ];
    }
}
