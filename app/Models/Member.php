<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory, HasApiTokens;

    protected $morphClass = 'member';

    // protected  $hidden = ['created_at','updated_at'];

    public function user()
    {
      return $this->morphOne(User::class, 'userable');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function count_points_for_member_in_campaign($campaign_id,$member_id) 
    {
         $all_points = 0;
         
         $member = Member::where('id',$member_id)->first();
           if($member){
              $bills = $member->bills;
              
              if(count($bills) > 0 ){
                foreach($bills as $bill){
                 
                  $points = Point::where('campaign_id',$campaign_id)->where('reset',0)->where('bill_id',$bill->id)->orWhere('member_id', $member->id)->get();
                
                  if(count($points) > 0 ){
                    foreach($points as $point){
                      $all_points += $point->amount;
                    }
                
                  }
                  
                }
               
              }
              
              return $all_points;
            }
    }

}
