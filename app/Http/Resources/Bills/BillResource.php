<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Distributor;

class BillResource extends JsonResource
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

        $distributor_name = "";
        if($this->distributor_id !== null){
            $distributor_name = Distributor::where('id',$this->distributor_id)->first()->name;
        }

        return [
            'id' => $this->id,
            'distributor_id' => $this->distributor_id,
            'distributor_name' => $distributor_name,
            'member_id' => $this->member_id,
            'bill_image' => $bill_image,
            'upload_date' => $this->upload_date,
            'bill_code' => $this->bill_code,
            // 'insert_date' => $this->insert_date,
            // 'admin_id ' => $this->admin_id ,
        ];
    }
}
