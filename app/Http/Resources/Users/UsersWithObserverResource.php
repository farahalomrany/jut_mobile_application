<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Distributor;
use App\Models\Observer;

class UsersWithObserverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
        return [
            'id' => $this->id,
            'first_name' => $this->fstName,
            'last_name' => $this->lstName,
            'city_id' => $this->city_id,
            'isActive' => $this->is_active,
        ];
    }
}
