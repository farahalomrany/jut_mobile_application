<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Models\User;
use App\Http\Resources\Users\UsersWithDistributorResource;

class DistributorController extends BaseController
{
    //get all distributors with filter by[id - city_id - isActive ]
    public function distributors_by_id_cityId_isActive(Request $request){
        
        $users = User::where('userable_type',"distributor")->where($request->filters)->get();
         
        if (isset($users)) {
             
            $data['distributors']    = UsersWithDistributorResource::collection($users);
            
            return $this->sendResponse($data, 'Distributors retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

}
