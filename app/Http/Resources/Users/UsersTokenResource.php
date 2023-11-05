<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersTokenResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $is_active = 0;
        $image = "#";

        if($this->image !== null){
            $image = url('storage').'/'.$this->image;
        }

        if($this->is_active !== null){
            $is_active = $this->is_active;
        }
        return [
            'id' => $this->id,
            'fstName' => $this->fstName,
            'lstName' => $this->lstName,
            'image' => $image,
            'phone_number' => $this->phone_number,
            'isActive' => $is_active,
            'Userable_type' => $this->userable_type,
            
            
        ];
    }
}
