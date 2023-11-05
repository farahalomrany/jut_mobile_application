<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['member_id', 'campaign_id','gift_name_inx_id','date','claim_id'];
    

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }

    public function giftNameInx()
    {
        return $this->belongsTo(GiftNameInx::class,'gift_name_inx_id','id');
    }

    public function claim()
    {
        return $this->belongsTo(Claim::class,'claim_id','id');
    }

    public static function boot()
    {
       
        $class = static::class;
        parent::boot();
        static::created(function($model)
        {
          
            $claim_id = $model->claim_id;
            $claim = Claim::where('id',$claim_id)->first();
            if($claim){
                $member_id = $claim->member_id;
                $user = User::where('userable_id',$member_id)->first();
                $BaseC = new BaseController();
                if($user){

                        //send notification 
                        $notification = new Notification();
                        $notification->sender_id  = $user->id; //juton
                        $notification->receiver_id  = $user->id;
                        $notification->body = "Congratulations!!Juton has been give you gifts ";
                        $notification->save();

                        // $BaseC = new BaseController();
                        $BaseC->sendNotification($user ,$notification->body);

                }
                else{
                    return $BaseC->sendError([],"The user does not have user model");
                }
            }
            

        });
        
    }

}
