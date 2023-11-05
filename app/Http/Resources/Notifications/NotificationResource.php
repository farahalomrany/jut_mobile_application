<?php

namespace App\Http\Resources\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $sender_name = "";
        
        $user = User::where('id',$this->sender_id)->first();
        if($user){
            $sender_name = $user->fstName;
        }
      

        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id ,
            'sender_name' => $sender_name ,
            'receiver_id' => $this->receiver_id ,
            'body' => $this->body,
            'date' => $this->created_at,
            
        ];
    }
}
