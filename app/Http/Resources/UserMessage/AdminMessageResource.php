<?php

namespace App\Http\Resources\UserMessage;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $title = "";
        if($this->title !== null){
            $title = $this->title;
        }
       
        return [
            'id' => $this->id,
            'date' => $this->date,
            'text' => $this->text,
            'title' => $title,
            'admin_id' => $this->admin_id ,
            
        ];
    }
}
