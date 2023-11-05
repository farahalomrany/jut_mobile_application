<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Distributor;
use App\Models\CityInx;

class UsersWithDistributorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        $shop_name = "";
        $address = "";
        $phone_number = "";
        $city_id = "";
        $city_name = "";
        if($this->phone_number !== null){
            $phone_number = $this->phone_number ;
        }

        if($this->city_id !== null){
            $city_id = $this->city_id ;
            $city = CityInx::where('id',$city_id)->first();
            if($city){
                $city_name = $city->name;
            }
        }

        $distributor = Distributor::where('id',$this->userable_id)->first();
        if($distributor){
            $shop_name = $distributor->name;
            $address = $distributor->address;
        }
      
        return [
            'id' => $this->id,
            'first_name' => $this->fstName,
            'last_name' => $this->lstName,
            'shop_name' => $shop_name,
            'city_id' => $city_id,
            'city_name' => $city_name,
            'address' => $address,
            'phone' => $phone_number,
            'isActive' => $this->is_active,
        ];
    }
}
