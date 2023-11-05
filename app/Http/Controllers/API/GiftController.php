<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\GiftNameInx;
use App\Models\Campaign;
use App\Models\Gift;
use App\Models\Member;
use App\Traits\CampaignTrait;
use App\Http\Resources\GiftsNamesInx\GiftsNamesInxResource;
use App\Http\Resources\GiftsNamesInx\GiftWithMembersResource;
use App\Http\Resources\GiftsNamesInx\GiftResource;

class GiftController extends BaseController
{
    use CampaignTrait;

    public function gifts_names()
    {
        $giftsNamesInxs = GiftNameInx::all();
         
        if (isset($giftsNamesInxs)) {

            $data['giftsNamesInxs']    = GiftsNamesInxResource::collection($giftsNamesInxs);
            
            return $this->sendResponse($data, 'gifts retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

    public function given_gifts(Request $request)
    {
        
        $given_gifts = [];
        $campaign_id = $this->current_campaign();
        
        if($campaign_id !== null){
            $campaign = Campaign::where('id',$campaign_id)->first();
        
            $claims = $campaign->claims;
           
            if(count($claims) > 0){
                foreach($claims as $claim){
                    
                    $gifts = Gift::where('claim_id',$claim->id)->where($request->filters)->get();
                    
                    foreach($gifts as $gift){
                        $given_gifts[] = $gift;
                        
                    }
    
                }
            }
            $request['campaign_id'] = $campaign_id;
            if (isset($given_gifts)) {
    
                $data['given_gifts']    = GiftResource::collection($given_gifts);
                
                return $this->sendResponse($data, 'Given gifts retrived successfully.');
            } 
            else {
                return $this->sendError([],"error");
            }

        }
        else{
            return $this->sendError([],"No campaign now!!");
        }
   
    }

    public function given_gifts_by_id(Request $request,$id)
    {
        $members = [];
        $gifts = Gift::where('gift_name_inx_id',$id)->get();
        if (isset($gifts)) {
            $data = GiftWithMembersResource::collection($gifts);
            return $this->sendResponse($data, 'gifts retrived successfully.'); 
        }
        else{
            return $this->sendError([],"error");
        }
      
    }

    public function mygifts()
    {
        $gifts = [] ;

        $user_id = Auth()->user()->userable_id;
        $member = Member::where('id',$user_id)->first();
       
        $claims = $member->claims;
        
        foreach($claims as $claim){

            $giftNameInx = Gift::where('claim_id', $claim->id)->get();

            foreach($giftNameInx as $gift){
              
                $gifts[] = $gift;

            }
            
        }
        if (isset($gifts)) {

            $data['gifts']    = GiftResource::collection($gifts);
            
            return $this->sendResponse($data, 'My gifts retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
       

    }

}
