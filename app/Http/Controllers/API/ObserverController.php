<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Users\UsersWithObserverResource;

class ObserverController extends BaseController
{
    //get all observers with filter by[id - city_id - isActive ]
    public function observers_by_id_cityId_isActive(Request $request)
    {
        
        $users = User::where('Userable_type',"observer")->where($request->filters)->get();
        
        if (isset($users)) {
            
            $data['observers']  = UsersWithObserverResource::collection($users);
        
            return $this->sendResponse($data, 'Observers retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }
}
