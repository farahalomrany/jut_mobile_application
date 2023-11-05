<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\Member;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Notifications\NotificationResource;
use App\Http\Resources\Products\ProductDetailResource;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    //get all notifications 
    public function notifications(Request $request)
    {
        $user_id = Auth()->user()->id;
        $notifications = Notification::where('receiver_id',$user_id)->orderBy('id', 'desc')->paginate(20);
       
        if (isset($notifications)) {

            foreach($notifications as $notification){

                $notification->read_at = Carbon::now();
                $notification->save();
    
            }

            $data['notifications']    = NotificationResource::collection($notifications);

            $original               = response()->json($notifications);
            $original               = json_decode($original->content(), true);

            $data['current_page']   = $original['current_page'];
            $data['per_page']       = $original['per_page'];
            $data['last_page']      = $original['last_page'];
            $data['total']          = $original['total'];
           
            return $this->sendResponse($data, 'notifications retrived successfully.');
        } 
        else {
            return $this->sendError([],"error");
        }
    }

    public function saveDeviceToken(Request $request)
    {
       
        $user = Auth()->user();

        $input = $request->all();

        $validator = Validator::make($input, [
            'device_token' => 'required',
        ]);
    
       if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }
      
        $user->device_token = $input['device_token'];
        // $user->update(['device_token'=>$input['device_token']]);
        $user->save();
        return $this->sendResponse([], 'Device token saved successfully.');

    }
    

}
