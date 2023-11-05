<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['bill_id', 'campaign_id','amount','reason','reset'];

    public function bill()
    {
        return $this->belongsTo(Bill::class,'bill_id','id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'campaign_id','id');
    }

    public function count_points_for_member_in_campaign_by_bill($campaign_id,$bill_id) 
    {
        $all_points = 0;

        $bill = Bill::where('id',$bill_id)->first();

        if($bill){

          $member_id = $bill->member_id;

          $member = Member::where('id',$member_id)->first();
          if($member){

                $all_points = 0;
                //points for this member in current campaign
            
                $billproducts =  $bill->billproducts;
                foreach($billproducts as $billproduct){

                        $size = $billproduct->size;

                        $current_campaign_id =  $campaign_id;

                        $campaignProduct = CampaignProduct::where('campaign_id',$current_campaign_id)->where('product_id',$billproduct->product_id)->first();
                            if($campaignProduct){
                                $points = $campaignProduct->points;

                                foreach (json_decode($points ,true) as $key => $value){

                                    $point_for_this_product = $value['size'];
                                    if($point_for_this_product == $size){
    
                                        $all_point_for_this_product = $value[$member->classification] * $billproduct->amount;
        
                                        $all_points = +$all_point_for_this_product;
                                    }
                                }
                                 
                            }

                }
                
                return $all_points;
        }
        else{
            return $this->sendError([],"member not exist");
        }
        }
    }

    public static function boot()
    {
        $class = static::class;
      
        parent::boot();

        static::creating(function($model)
        {
           
          if($model->bill_id){

            $bill_id = $model->bill_id;
            $campaign_id = $model->campaign_id;
            $points = $model->count_points_for_member_in_campaign_by_bill($campaign_id,$bill_id);
            $model->amount = $points;
            
        }
          
        });

    } 
}
