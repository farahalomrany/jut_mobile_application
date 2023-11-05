<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CampaignProduct extends Model
{
    use HasFactory, HasApiTokens;

    public function save(array $options = [])
    {
        // Do whatever you want
        $this->points = json_encode(request()->input('points'));
        parent::save();
    }


    protected $fillable = ['campaign_id', 'product_id', 'points'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function boot()
    {
        $class = static::class;

        parent::boot();

        static::updated(function ($model) {
            $campaign = Campaign::where('id', $model->campaign_id)->first();
            if ($campaign) {
                $date = $campaign->start_date;
                $now = Carbon::now()->toDateString();
                $start_date = Carbon::parse($date);

                if ($start_date->lte($now)) {

                    return response()->json("you cant edit");

                }


            }

        });

    }

    // public function points_json($points)
    // {
    //     // $points = '{"0":{"size":"D","silver":"11","gold":"11","platinum":"11"},"01":{"size":"L","silver":"22","gold":"22","platinum":"22"}}';
    //     $details_string = "";
    //     // $string_array = [];
    //     $count=1;
    //     foreach (json_decode($points, true) as $key => $value) {

    //         $details_string = $details_string . "{$count} - size : {$value["size"]} , gold points : {$value["gold"]} , silver points : {$value["silver"]} , platinum points : {$value["platinum"]}  . ";
    //         //for array return
    //         // $details_string = "for size {$value["size"]} , gold points : {$value["gold"]} , silver points : {$value["silver"]} , platinum points : {$value["platinum"]}";

    //         // $string_array[$count] = $details_string;
    //         $count ++;

    //     }
    //     //for array return
    //     // return $string_array;

    //     return $details_string;
    // }
    // public function getPointsAttribute()
    // {
    //     return $this->points_json($this->attributes['points']);
    // }

}