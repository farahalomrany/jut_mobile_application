<?php

namespace App\Http\Resources\UserMessage;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->sender_name !== null){
            $sender_name = $this->sender_name;
        }
        else{
            $sender_name = "";
        }


        return [
            'sender_name' => $sender_name,
            'phone_number' => $this->phone_number,
            'mtype' => $this->mtype,
            'destination' => $this->destination,
            'receivers' => $this->receivers,
            'text' => $this->text,
            'date' => $this->date,
            'stype' => $this->stype,
            'sender_id' => $this->sender_id,
            
        ];
    }
}