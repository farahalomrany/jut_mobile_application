<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Campaigns\CampaignResource;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CampaignController extends BaseController
{
    public function current_campaign(){
        
        $now = Carbon::now()->toDateString();
        $campaign  = Campaign::where('start_date','<=',$now)->where('end_date','>=',$now)->first();

        if (isset($campaign)) {
            
            return $this->sendResponse(new CampaignResource($campaign), 'campaign retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

    public function camp(Request $request)
    {
        
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'gain_start_date' => 'required|date',
            'gain_end_date' => 'required|date',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }
        
            $campaign = new Campaign();
             
            $campaign->start_date  = $input['start_date'];
            
            $campaign->end_date = $input['end_date'];

            $campaign->gain_start_date = $input['gain_start_date'];

            $campaign->gain_end_date = $input['gain_end_date'];
           
            $campaign->save();

            // return $campaign;
            return $this->sendResponse(new campaignResource($campaign),'Bill has uploaded successfully.');
           
        }
       

    
}
