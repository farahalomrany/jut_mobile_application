<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CityInx;

class UsersResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $accessToken = $this->createToken('API Token')->plainTextToken;

        $is_active = 0;
        $image = "#";

        if($this->image !== null){
            $image = url('storage').'/'.$this->image;
        }

        if($this->is_active !== null){
            $is_active = $this->is_active;
        }
        $city_name = " ";
        if($this->city_id  !== null){
            $city_id  = $this->city_id ;
            $city = CityInx::where('id',$city_id)->first();
            if($city){
                $city_name = $city->name;
            }
            
        }
        return [
            'id' => $this->id,
            'fstName' => $this->fstName,
            'lstName' => $this->lstName,
            'image' => $image,
            'phone_number' => $this->phone_number,
            // 'access_token' => $this->remember_token,
            'isActive' => $is_active,
            
            'access_token' => $accessToken,
        ];
    }
}
