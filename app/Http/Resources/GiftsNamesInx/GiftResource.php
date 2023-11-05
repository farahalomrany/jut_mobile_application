<?php

namespace App\Http\Resources\GiftsNamesInx;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Campaign;

class GiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $points = 0;
        $giftsNames = Campaign::where('id',$request['campaign_id'])->first()->giftsNames;
        if($giftsNames !== null){
            foreach (json_decode($giftsNames ,true) as $key => $giftsName){
                        
                        
                //return details gifts
                $gift_id = $giftsName['id'];
                if($this->gift_name_inx_id == $gift_id){
                    $points = $giftsName['points'];
                }
                
            }
        }

        $gift_name = "";
        $gift_image = "#";
        $gift_description = "";

        if($this->gift_name_inx_id !== null){

            $giftNameInx = $this->giftNameInx;

            $gift_name = $giftNameInx->name ;
           
            if($giftNameInx->image !== null){
                $gift_image = url('storage').'/'.$giftNameInx->image;
            }
            
            $gift_description = $giftNameInx->description ;
        }

        return [
            'id' => $this->id,
            'gift_name_inx_id' => $this->gift_name_inx_id ,
            'gift_name' => $gift_name ,
            'points' => $points ,
            // 'gift_description' => $gift_description ,
            'gift_image' => $gift_image ,
            'date' => $this->date,
            // 'claim_id ' => $this->claim_id ,
           
        ];
    }
}
