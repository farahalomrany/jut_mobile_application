<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;
use App\Models\User;

class BillForDistributorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        // $language = $request->header('Accept-Language');
        // $name =   $this->getTranslatedAttribute('name', $language , 'en');

        $bill_image = "#";

        if($this->bill_image !== null){
            $bill_image = url('storage').'/'.$this->bill_image;
        }

        if($this->bill_code !== null){
            $bill_code = "";
        }

        $member_work = "";
        $fstName = "";
        if($this->member_id !== null){
            $member_work = Member::where('id',$this->member_id)->first()->work;
            $fstName = User::where('userable_id',$this->member_id)->where('userable_type',"member")->first()->fstName;
        }

        return [
            'id' => $this->id,
            // 'distributor_id' => $this->distributor_id,
            'member_work' => $member_work,
            'member_name' => $fstName,
            'member_id' => $this->member_id,
            'bill_image' => $bill_image,
            'upload_date' => $this->upload_date,
            'bill_code' => $this->bill_code,
            
            // 'insert_date' => $this->insert_date,
            // 'admin_id ' => $this->admin_id ,
        ];
    }
}
