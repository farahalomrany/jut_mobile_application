<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Admin;
use App\Models\Member;
use App\Models\Observer;
use App\Models\Distributor;

class UsersWithDetailsProfileResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $is_super = 0;
        $classification = "";
        $work = "";
        $shop_name = "";
        $address = "";
        $image = "#";
        $lstName = "";
        $fstName = "";
      
        if($this->lstName !== null){
            $lstName = $this->lstName;
        }
        if($this->fstName !== null){
            $fstName = $this->fstName;
        }
        if($this->image !== null){
            $image = url('storage').'/'.$this->image;
        }

        if($this->userable_type == "admin"){
            $admin = Admin::where('id',$this->userable_id)->first();
            if($admin){
                $is_super = $admin->is_super;
            }

        }
        
        if($this->userable_type == "observer"){
            $observer = Observer::where('id',$this->userable_id)->first();
            if($observer){
                $id = $observer->id;
            }

        }
        
        if($this->userable_type == "distributor"){
            $distributor = Distributor::where('id',$this->userable_id)->first();
            if($distributor){
                $shop_name = $distributor->name;
                $address = $distributor->address;
            }

        }
        
        if($this->userable_type == "member"){
            $member = Member::where('id',$this->userable_id)->first();
            if($member){
                $classification = $member->classification;
                $work = $member->work;
            }

        }

        return [
            'id' => $this->id,
            'fstName' => $fstName,
            'lstName' => $lstName,
            'image' => $image,
            'phone_number' => $this->phone_number,
            'isActive' => $this->is_active,
            'Userable_id' => $this->userable_id ,
            'Userable_type' => $this->userable_type,
            'classification' => $classification,
            'work' => $work,
            'shop_name' => $shop_name,
            'address' => $address,
        
        ];
    }
}
