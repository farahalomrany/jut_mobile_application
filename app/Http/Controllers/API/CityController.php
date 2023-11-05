<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\CityInx;
use App\Http\Resources\Cities\CityResource;

class CityController extends BaseController
{

    //get all cities with filter by[id]
    public function cities()
    {
        $cities = CityInx::all();
       
        if(request()->id){
            $cities = $cities->where('id','=',request()->id);
        
        }
        if (isset($cities)) {
            
            $data['cities']    = CityResource::collection($cities);
            
            return $this->sendResponse($data, 'Cities retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

    public function get_work()
    {
        $work = ['engineer','painter','contractor','workshop_owner'];

        $data['work']    = $work;
            
        return $this->sendResponse($data, 'Work retrived successfully.');
      
    }


}
