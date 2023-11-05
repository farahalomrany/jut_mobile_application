<?php

namespace App\Http\Resources\GiftsNamesInx;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Claim;
use App\Http\Controllers\BaseController;

class GiftWithMembersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        $fstName = " ";
        if($this->claim_id !== null){

            $claim = Claim::where('id',$this->claim_id)->first();
            if($claim){
                $member = $claim->member;
                if($member){
                    if($member->user){
                        $fstName = $member->user->fstName;
                    }
                    else{
                        return BaseController::sendError([],"there is not user");
                        
        
                    }

                }
                else{
                    return BaseController::sendError([],"there is not member");
                  
    
                }

            }
            else{
                return BaseController::sendError([],"there is not claim");

            }

        
        }

        return [
            'fstName' => $fstName ,
            'date' => $this->date,
            // 'claim_id ' => $this->claim_id ,
           
        ];
    }
}
