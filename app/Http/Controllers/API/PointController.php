<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Member;
use App\Models\Campaign;
use App\Models\GiftNameInx;
use App\Models\CampaignProduct;
use App\Traits\CampaignTrait;
use Illuminate\Http\Request;

class PointController extends BaseController
{
    use CampaignTrait;

    public function points()
    {
        
        $userable_type = Auth()->user()->userable_type;
        
        if($userable_type == "member" && Auth()->user()->userable_id != null){

            $userable_id = Auth()->user()->userable_id;
            $member = Member::where('id',$userable_id)->first();
         
            if($member){
                if($member !== null){

                    $all_points = 0;
                    $maxPointsGift = 0;
                    $all_gifts = [];
                    
                    //points for this member in current campaign
                    $bills = $member->bills;
                    if(count($bills) > 0){
                        foreach($bills as $bill){

                            $billproducts =  $bill->billproducts;
                            foreach($billproducts as $billproduct){
                                
                                $size = $billproduct->size;
                                $classification = $member->classification;

                                $current_campaign_id =  $this->current_campaign();
                                if($current_campaign_id !== null){
                                    $campaignProduct = CampaignProduct::where('campaign_id',$current_campaign_id)->where('product_id',$billproduct->product_id)->first();
                                    if($campaignProduct){
                                       
                                        $points = $campaignProduct->points;
                                        
                                        foreach (json_decode($points ,true) as $key => $value){
                                            
                                            if($value['size'] == $size ){
                                                $point_for_this_product =  $value[$member->classification];
    
                                            
                                                $all_point_for_this_product =  $point_for_this_product * $billproduct->amount;
            
                                                $all_points = +$all_point_for_this_product;
                                                
                                            }
                                           
                                        }
                                       
                                        
                                    }
                                }
                                else{
                                    return $this->sendError([],"No Campaign now !!");

                                }
                               

                            }
                        }

                        
                        
                    }

                    //return max points in this campaign
                    $current_campaign_id =  $this->current_campaign();
                   
                    if($current_campaign_id !== null){
                        $giftsNames = Campaign::where('id',$current_campaign_id)->first()->giftsNames;
                    
                        foreach (json_decode($giftsNames ,true) as $key => $giftsName){
                        
                            $pointGift = $giftsName['points'];
                            if($pointGift > $maxPointsGift){
                                $maxPointsGift = $pointGift;
                            }
                        
                      
                        }

                        foreach (json_decode($giftsNames ,true) as $key => $giftsName){
                        
                        
                            //return details gifts
                            $gift_id = $giftsName['id'];
                            
                            $gift = GiftNameInx::where('id',$gift_id)->first();

                            $gifts = [];
                            if($gift){
                                // return $giftsName['points'];
                                $gifts['id'] = $gift->id;
                                $gifts['points'] = $giftsName['points'];
                                $gifts['image'] = url('storage').'/'.$gift->image;
                            
                                $all_gifts[] = $gifts;
                            }

                        }


                        $data['all_points'] = $all_points;
                        $data['max_points'] = $maxPointsGift;
                        $data['all_gifts'] = $all_gifts;
                        return $this->sendResponse($data, 'Points retrived successfully.');
                    }
                    else{
                        return $this->sendError([],"No Campaign now !!");
                    }
                    
                }

            }
            else{
                return $this->sendError([],"member not exist");
            }
        }

    }
}
