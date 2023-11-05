<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserMessage;
use App\Models\User;
use App\Models\Distributor;
use App\Http\Resources\UserMessage\UserMessageResource;
use App\Http\Resources\Distributors\DistributorOnlyResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserMessageController extends BaseController
{
    
    public function send_message_member_or_distributor(Request $request)
    {
        $user_id = Auth()->user()->id;

        $input = $request->all();
        
        $validator = Validator::make($input, [
            'mtype' => 'required|in:query,objection',
            'destination' => 'required|in:dist,company,both',
            'text' => 'required|string',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }

        $message = new UserMessage();

        if($input['destination'] == "dist" || $input['destination'] == "both"){
 
                $validator = Validator::make($input, [
                    'receivers' => 'required',
                ]);
            
                if ($validator->fails()) {
                    return $this->sendError([],$validator->errors()->first());
                }

                $receiversIds = $input['receivers'];
                $receiversIds = json_decode($receiversIds, true); 

                $receiversdists = [];
                if (is_array($receiversIds)) {
                    
                    if (isset($receiversIds[0])) {
                        foreach ($receiversIds as $key=>$receiversId) { 
                            
                            if(Distributor::find($receiversId)){ 
                               
                                $is_user = User::where('userable_type',"distributor")->where('userable_id',$receiversId)->first();
                                if(!$is_user){
                                   
                                    return $this->sendError([], "This Distributor $receiversId doesnt has user model");
                                }
                                $receiversdists[] = $receiversId;
                                                        
                            }
                            else{
                                return $this->sendError([], "Distributor $receiversId doesnt exist");
                            }
                        }
                            $receiversdists = json_encode($receiversdists); 
                            $message->receivers = $receiversdists; 
                    }
                    else{
                        return $this->sendError([], "You didnt insert any receivers id");
                    }
                }
                else{
                    return $this->sendError([], "receiversIds is not array");
                }
        }

        $message->mtype = $input['mtype'];
        $message->destination = $input['destination'];
        $message->text = $input['text'];;
        $message->date = Carbon::now()->toDateString();
        $message->sender_name = Auth()->user()->fstName;
        $message->sender_id = $user_id;
        if(Auth()->user()->userable_type !== null){
            $message->stype = Auth()->user()->userable_type;
        }
        else{
            $message->stype = "";
        }
        $message->status = "new";

        if(Auth()->user()->phone_number !== null){
            $message->phone_number = Auth()->user()->phone_number;
        }
        else{
            $message->phone_number = "";
        }

        $message->save();
        return $this->sendResponse(new UserMessageResource($message), 'user send message successfully'); 

    }

    public function onlyDistributors(Request $request){
        $distributors = [];
        $alldistributors = Distributor::all();
        if(count($alldistributors) > 0){
            foreach($alldistributors as $distributor){
                if($distributor->user){
                    $distributors[] = $distributor;
                }
                
            }
                   
            $data['distributors']    = DistributorOnlyResource::collection($distributors);
            
            return $this->sendResponse($data, 'Distributors retrived successfully.');

        }
         
        // if (isset($distributors)) {
      
        // } 
        // else {
        //     return $this->sendError([],"error");
        // }
    }

    public function send_message_by_guest(Request $request)
    {
        
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'sender_name' => 'required|string|min:2|max:32',
            'phone_number' => 'required|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'mtype' => 'required|in:query,objection',
            'destination' => 'required|in:dist,company,both',
            'text' => 'required|string',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }
       
        $message = new UserMessage();

        if($input['destination'] == "dist" || $input['destination'] == "both"){
 
            $validator = Validator::make($input, [
                'receivers' => 'required',
            ]);
        
            if ($validator->fails()) {
                return $this->sendError([],$validator->errors()->first());
            }

            $receiversIds = $input['receivers'];
            $receiversIds = json_decode($receiversIds, true); 

            $receiversdists = [];
            if (is_array($receiversIds)) {
                
                if (isset($receiversIds[0])) {
                    foreach ($receiversIds as $key=>$receiversId) { 
                        
                        if(Distributor::find($receiversId)){ 
                           
                            $receiversdists[] = $receiversId;
                                                    
                        }
                        else{
                            return $this->sendError([], "Distributor $receiversId doesnt exist");
                        }
                    }
                        $receiversdists = json_encode($receiversdists); 
                        $message->receivers = $receiversdists; 
                }
                else{
                    return $this->sendError([], "You didnt insert any receivers id");
                }
            }
            else{
                return $this->sendError([], "receiversIds is not array");
            }
        }
        
        $message->mtype = $input['mtype'];
        $message->destination = $input['destination'];
        $message->text = $input['text'];
        $message->date = Carbon::now()->toDateString();
        $message->sender_name = $input['sender_name'];

        $message->stype = "visitor";
        
        $message->status = "new";

        $message->phone_number = "963".$input['phone_number'];
        
        $message->save();
        return $this->sendResponse(new UserMessageResource($message), 'Visitor send message successfully'); 

    }

         //get memebers messages for distributors
         public function get_memebers_messages()
         {
           
             $userable_type = Auth()->user()->userable_type;
             $all_messages = [];
           
             if($userable_type == "distributor"){
                
                     $messages = UserMessage::all();
                     
                     foreach($messages as $user_message){
                         $destination = $user_message->destination;
                      
                         if($destination == "dist" || $destination == "both"){
                            if($user_message->receivers !== null){
                                foreach(json_decode($user_message->receivers ,true) as $key=> $value){
                                
                                    if($value == Auth()->user()->userable_id){
                                        $all_messages[] = $user_message;
    
                                    }
                                }
                            }
                          
    
                         }
                        
                     }
     
                 $data['messages']    = UserMessageResource::collection($all_messages);
                 return $this->sendResponse($data, 'messages retrived successfully.');
             }
             else {
                 return $this->sendError([],"error");
             }
         }

}