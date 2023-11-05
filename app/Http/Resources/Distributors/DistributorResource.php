<?php

namespace App\Http\Resources\Distributors;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class DistributorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        // $user = $this->user;
        $first_name = "";
        $last_name = "";
        $city_id = "";
        $isActive = "";
        $user = User::where('userable_id',$this->id)->where('userable_type',"distributor")->first();
        if($user){
            $first_name = $user->fstName;
            $last_name = $user->lstName	;
            $city_id = $user->city_id;
            $isActive = $user->is_active;

        }
      

        return [
            'id' => $this->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'shop_name' => $this->name,
            'city_id' => $city_id,
            'address' => $this->address,
            'isActive' => $isActive,
        ];
    }
}
