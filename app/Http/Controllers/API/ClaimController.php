<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Observer;
use App\Models\Claim;
use App\Models\Campaign;
use App\Http\Resources\Claims\ClaimResource;
use App\Traits\CampaignTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class ClaimController extends BaseController
{
    use CampaignTrait;

    public function claim(Request $request)
    {
        
        $user_id = Auth()->user()->userable_id;
       
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'campaign_id' => 'required|exists:campaigns,id',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }
            
            $current_campaign_id = $this->current_campaign();
            
            
            if($current_campaign_id !== null){

                if($current_campaign_id == $input['campaign_id']){

                    $gain_start_date = Campaign::where('id',$current_campaign_id)->first()->gain_start_date;
                    $gain_start_date = Carbon::parse($gain_start_date)->toDateString();

                    $gain_end_date = Campaign::where('id',$current_campaign_id)->first()->gain_end_date;
                    $gain_end_date = Carbon::parse($gain_end_date)->toDateString();

                    $now = Carbon::now()->toDateString();
    
                    if($gain_start_date->lte($now) && $now->lte($gain_end_date)){
          
                        $claim = new Claim();
    
                        $claim->campaign_id   = $current_campaign_id;
                        
                        $claim->member_id  = $user_id;
            
                        $claim->date  = Carbon::now()->toDateString();
            
                        $claim->status  = "new";
                    
                        $claim->save();
                    
                        return $this->sendResponse(new ClaimResource($claim),'Claim has created successfully.');
    
                    }
                    else{
                        return $this->sendError([],"The gain date has not started yet");
                    }
    
                }
                else{
                    return $this->sendError([],"This campaign is not the current campaign");
                }

            }
            else{
                return $this->sendError([],"No campaign now!!");
            }
            
    }

    public function claims(Request $request)
    {
        
        $current_campaign_id = $this->current_campaign();
        if($current_campaign_id !== null){

            $claims = Claim::where('campaign_id',$current_campaign_id)->get();

            if (isset($claims)) {
                $data['claims']    = ClaimResource::collection($claims);
                return $this->sendResponse($data, 'claims retrived successfully.');
            } 
            else {
                return $this->sendError([],"error");
            }

        }
        else {
            return $this->sendError([],"No campaign now!!");
        }
       

    }

}