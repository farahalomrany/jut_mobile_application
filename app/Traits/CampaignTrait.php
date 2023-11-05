<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Member;
use App\Models\Point;
use App\Models\Bill;

trait CampaignTrait {

    //get current campaign
    public function current_campaign() 
    {
        $now = Carbon::now()->toDateString();
        // $start_date = Carbon::parse($start_date);
        
        $currentCampaign = Campaign::whereDate('start_date','<=',$now)->whereDate('end_date','>',$now)->first();
     
        if($currentCampaign){
            return $currentCampaign->id;
        }
        else{
            return null;
            // $response['success'] = false;
            // $response['data'] = [];
            // $response['status_code'] = 404;
            // $response['errors'] = ["There is not any campaign has started yet"];
            // return response()->json($response,404);
        }

    }

    public function given_points_number($campaign_id) 
    {
     
        $campaign = Campaign::where('id',$campaign_id)->first();

        $given_point_number = 0;

        $points = $campaign->points; //check if reset is false
        // return $points;
        if(count($points) > 0){
            foreach($points as $point){

                $amount	= $point->amount;
                $given_point_number += $amount;
            }
           
        }
        return $given_point_number;
    }

    public function users_number($campaign_id) 
    {

        $campaign = Campaign::where('id',$campaign_id)->first();

        $users_number = 0;

        $users = User::where('userable_type',"member")->where('userable_id','!=',null)->get();

        if(count($users) > 0){
            foreach($users as $user){

                $userable_id = $user->userable_id;

                $member = Member::where('id',$userable_id)->first();
                if($member){
                   $bills = $member->bills;
                   if(count($bills) > 0){
                    foreach($bills as $bill){
                        $points = Point::where('bill_id',$bill->id)->where('campaign_id',$campaign_id)->get();
                        if(count($points) > 0){
                            $users_number += 1;
                        }
                    }
                   }
                }
               
            }

            return $users_number;
        }

    }

}