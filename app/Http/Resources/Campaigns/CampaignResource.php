<?php

namespace App\Http\Resources\Campaigns;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Campaigns\CampaignProductResource;
use App\Traits\CampaignTrait;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    use CampaignTrait;

    public function toArray($request)
    {
       
        // $language = $request->header('Accept-Language');
        // $name =   $this->getTranslatedAttribute('name', $language , 'en');
        $gifts_names = [];
        $distributors = [];
        if($this->giftsNames !== null){
            
            $gifts_names = json_decode($this->giftsNames, true);
        }

        if($this->distributors !== null){
            
            $distributors = json_decode($this->distributors, true);
        }

        $users_number = 0;
        $given_points_number = 0;
        $description = "";

        if($this->description !== null){
            
            $description = $this->description;
        }

        if($this->given_points_number($this->id) !== null){
            $given_points_number = $this->given_points_number($this->id);
        }
        if($this->users_number($this->id) !== null){
            $users_number = $this->users_number($this->id);
        }

        $campaignproducts = $this->campaignproducts;
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'gain_start_date' => $this->gain_start_date ,
            'gain_end_date' => $this->gain_end_date ,
            'description' => $description ,
            'giftsNames' => $gifts_names ,
            'distributors' => $distributors ,
            'users_number' => $users_number ,
            'given_points_number' => $given_points_number ,
            'products' => CampaignProductResource::collection($campaignproducts) ,
            
          
        ];
    }
}
