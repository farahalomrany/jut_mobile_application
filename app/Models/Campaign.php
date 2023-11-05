<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory, HasApiTokens;

    public function save(array $options = [])
    {
                // Do whatever you want
        $this->distributors = json_encode(request()->input('distributors'));
        $this->giftsNames = json_encode(request()->input('giftsNames'));

        parent::save();
    }

  
    protected $fillable = ['start_date', 'end_date', 'gain_start_date','gain_end_date','giftsNames',
                          'distributors','description'];

    public function campaignproducts()
    {
         return $this->hasMany(CampaignProduct::class);
    }

    public function points()
    {
         return $this->hasMany(Point::class);
    }


    public function products(){

        $products = Product::whereHas('campaignproducts', function ($q)  {
            $q->where('campaign_id', $this->id );
        })->get();

        return $products;
    }

    public function claims()
    {
         return $this->hasMany(Claim::class);
    }

           
    // public function setStartDateAttribute($value){

    //                $now = Carbon::now()->toDateString();
    //                $this->attributes['start_date'] = $value < $now ? $value : $now;
    // }

    // public function setEndDateAttribute($value){

    //     $now = Carbon::now()->toDateString();
    //     if($value > $this->attributes['start_date'] ){
    //         $this->attributes['end_date'] = $value;
    //     }
    //     else{
            
    //         return BaseController::sendError([],"error");
    //     }
        
    // }

    // public function setStartDateAttribute($value){

    //     $now = Carbon::now()->toDateString();
    //     $this->attributes['start_date'] = $value <= $now ? $value : $now;
    // }

    public static function boot()
    {
        $class = static::class;
      
        parent::boot();

        static::created(function($model)
        {
          
            $user_id = Auth()->user()->id;
            $BaseC = new BaseController();
            $users = User::where('userable_type',"member")->get();
            if(count($users) > 0){

                        //send notification 
                        foreach($users as $user){
                            $notification = new Notification();
                            $notification->sender_id  = $user_id; //juton
                            $notification->receiver_id  = $user->id;
                            $notification->body = "There is a new Capmaign";
                            $notification->save();
    
                            
                            $BaseC->sendNotification($user ,$notification->body);
                        }
                        
            }
            // else{
            //      return $BaseC->sendError([],"There are not any user");
            // }
        
        });

    }                  

    // public function giftname_json($giftname)
    // {
    //     // $giftname = '{"01":{"id":"2","points":"22"},"02":{"id":"1","points":"25"}}';
    //     $details_string = "";
    //     // $string_array = [];
    //     // $count=0; for return array
    //     foreach (json_decode($giftname ,true) as $key => $value){
             
    //             $details_string = $details_string . "gift id : {$value["id"]} , gift points : {$value["points"]}   .  ";
    //             //for array return
    //             // $details_string = "gift id : {$value["id"]} gift points : {$value["points"]}  ";
    //             // $string_array[$count] = $details_string;
    //             // $count ++;
              
    //     }
    //     //for array return
    //     // return $string_array;

    //     return $details_string;
    // }
    // public function getGiftsNamesAttribute()
    // {
    //     if ($this->attributes['giftsNames'] == null)
    //         return "";
    //     else
    //         return $this->giftname_json($this->attributes['giftsNames']);
    // }
    // public function distributors_json($distributors)
    // {
    //     // $distributors = '{"0":{"id":"2"},"01":{"id":"1"}}';
    //     $details_string = "";
    //     // $string_array = [];
    //     // $count=0; for return array
    //     foreach (json_decode($distributors ,true) as $key => $value){
             
    //             $details_string = $details_string . "distributors id : {$value["id"]}  .  ";
    //             //for array return
    //             // $details_string = "distributors id : {$value["id"]}  .  ";
    //             // $string_array[$count] = $details_string;
    //             // $count ++;
              
    //     }
    //     //for array return
    //     // return $string_array;

    //     return $details_string;
    // }

    // public function getDistributorsAttribute()
    // {
    //     if ($this->attributes['distributors'] == null)
    //         return "";
    //     else
    //         return $this->distributors_json($this->attributes['distributors']);
    // }
}
