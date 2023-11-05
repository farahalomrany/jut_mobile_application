<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use Image;
use Carbon\Carbon;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\Users\UsersWithDetailsResource;
use App\Http\Resources\Users\UsersTokenResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Users\UsersResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Spatie\Browsershot\Browsershot;
use App\Jobs\SendMessageJob;
use App\Jobs\SendMessageSyriatelJob;


class AuthController extends BaseController
{

    function redirectToSendMessageSyritel($code,$to)
    {
        $msg = "The verification code for your phone is $code ";
        
        $details = [];
        $details['msg'] = $msg;
        $details['to'] = $to;
      
        if(SendMessageSyriatelJob::dispatch($details)){
         
            return true; 
        }
        else{
         
            return false;
            
        }

    }

    function redirectToSendMessage($code,$to)
    {
        $msg = "The verification code for your phone is $code ";

        $details = [];
        $details['msg'] = $msg;
        $details['gsm'] = $to;
       
        if(SendMessageJob::dispatch($details)){ // ->delay(now()->addMinutes(5));
         
   
            return true; 
        }
        else{
         
            return false;
            
        }

    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'fstName' => 'required|string|min:2|max:32',
                'lstName' => 'required|string|min:2|max:32',
                'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'city_id' => 'required|exists:cities_inx,id',
                'password' => 'required|confirmed|min:8',
            ]);

        if ($validator->fails()) {
      
            return $this->sendError([],$validator->errors()->first());
        }

        $input = $request->all();
       
        $user = new User();
        $user->fstName = $input['fstName'];
        $user->lstName = $input['lstName'];
        $phone = "963".$input['phone_number'];
        if(User::where('phone_number',$phone)->first()){
            return $this->sendError([],"The phone number has already been taken.");
        }
        $user->phone_number = $phone;
       
        $user->city_id = $input['city_id'];
      
        $user->password = bcrypt($input['password']);
        
        if ($request->file('image')) {
            
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            
            $filename = uniqid() . '.png';

            $now = Carbon::now()->format('MY');
            
            $filePath = "users/" . $now . "/" . $filename;
           
            $image = Image::make($file)
            ->resize(512, 512, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();

            });

            if ($extension !== 'gif') {
                
                $image->orientate();
            }
            
            $image->encode($file->getClientOriginalExtension(), 75);
            
            if(Storage::disk(config('voyager.storage.disk'))->put($filePath,(string) $image, 'public')){
                $user->image = $filePath;
                
            }
        }
     
        $user->userable_type  = "member";

        $member = new Member();
    
        $member->save();

        $user->userable_id  = $member->id;

        // Six digits random code
        $number = sprintf("%06d", mt_rand(1, 999999));

        // Call the same function if exists already
        if ($this->isInviteNumberExists($number)) {
            return $this->generateInviteCode();
        }

        $user->code = $number;

        $user->save();
        
        $phone_number = substr($phone, strpos($phone, "9639") + 4); 
        // if($phone_number[0] == "4" || $phone_number[0] == "5" || $phone_number[0] == "6"){

        //         //mtn
        //         $res = $this->redirectToSendMessage($number,$phone);
        //         if($res ==true){

        //             return $this->sendResponse(new UsersResource($user), 'user has registered successfully');
        //         }
        //         else{
                
        //             return $this->sendError([],'Sending verification code failed');
        //         }
        // }
        // else{
            //syriatel
          
            $res = $this->redirectToSendMessageSyritel($number,$phone);
           
              if($res ==true){

                  return $this->sendResponse(new UsersResource($user), 'user has registered successfully');
              }
              else{
                
                   return $this->sendError([],'Sending verification code failed');
              }
            
        // }
       
    }

    public function codeVerify(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
                'code' => 'required',
            ]);

        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }

        $input = $request->all();

        $phone = "963".$input['phone'];
        $code = $input['code'];

        $user = User::where('phone_number', $phone)->where('code' ,$code)->first();
        if($user){
            $user->verified_at = Carbon::now();
            $user->save();

            return $this->sendResponse(new UsersResource($user), 'You are veryfied now');
        }
        else{
            return $this->sendError([],'You are not veryfied');
        }
    }

    public function resendcode(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(),
        [
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            
        ]);

        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }

        if($input['phone']){
           
            //948858334
            $phone_with_code = "963".$request['phone'];
           
            $user = User::where('phone_number', $phone_with_code)->first();
            if($user){
                
                    // Six digits random code
                    $number = sprintf("%06d", mt_rand(1, 999999));

                    // Call the same function if exists already
                    if ($this->isInviteNumberExists($number)) {
                        return $this->generateInviteCode();
                    }

                    $user->code = $number;
                    
                    $user->save();

                    $msg = "The verification code for your phone is $user->code ";
                    
                    $phone_number = substr($phone_with_code, strpos($phone_with_code, "9639") + 4); 
                    if($phone_number[0] == "4" || $phone_number[0] == "5" || $phone_number[0] == "6"){
                        
                        //mtn

                            $details = [];
                            $details['msg'] = $msg;
                            $details['gsm'] = $phone_with_code;
                        
                            if(SendMessageJob::dispatch($details)){ // ->delay(now()->addMinutes(5));
                                
                                return $this->sendResponse(new UsersResource($user), 'code has resend successfully'); 
                            }
                            else{
                                return $this->sendError([],'Sending verification code failed');
                            }
                    }
                    else{
                        //syriatel

                        $details = [];
                        $details['msg'] = $msg;
                        $details['to'] = $phone_with_code;
                        
                        if(SendMessageSyriatelJob::dispatch($details)){
                        
                    
                            return $this->sendResponse(new UsersResource($user), 'user has registered successfully'); 
                        }
                        else{
                        
                            return $this->sendError([],'Sending verification code failed');
                            
                        }
                        
                    }

            }
            else{
                return $this->sendError([],"User not exist");
            }
        }
        else{
            return $this->sendError([],"Phone number is required");
        }
    
    }

    
    function isInviteNumberExists($number)
    {
        $inviteNumber = User::where('code', '=', $number)->first();

        if ($inviteNumber === null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
        
    // Make random code from 6 digits
    function generateInviteCode() 
    {
             // 10  random charts
             $result = '';
             for ($i = 0; $i < 10; $i++) {
                 $result .= chr(rand(65, 90));
             }
             
           
             // Call the same function if exists already
             if ($this->isInviteNumberExists( $result)) {
                 return $this->generateInviteCode();
             }
            
             // otherwise, it's valid and can be used
             return $result;
    }

    public function login(Request $request)
    {
       
        $data = $request->all();
        $validation_rules = [
            'phone_number' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($data, $validation_rules);
        if ($validator->passes()) {
            $phone_number = "963".$data['phone_number'];
            // if (isset($data['phone_number']))
                $dbUser = User::where('phone_number', $phone_number)->first();
            
            if (!$dbUser) {
                return $this->sendError([],'phone is wrong');
            } else {
                if (Hash::check($data['password'], $dbUser->password)) {
                    $user = User::where('phone_number',$phone_number)->first();
                    // $user->remember_token = $user->createToken('API Token')->plainTextToken;
                    $user->save();
                    if($user->verified_at == null){
                        return $this->sendErrorLogin([],"You are not verified yet");

                    }
                    return $this->sendResponse(new UsersWithDetailsResource($dbUser), 'user login successfully');
                } else
                return $this->sendError([],'password is wrong');
            }
        } else {
            return $this->sendError([],$validator->errors()->first());
        }

    }

    public function logout(Request $request)
    {
        
        auth()->user()->tokens()->delete();

        auth()->user()->save();
        
        return $this->sendResponse([],'tokens evoked');

    }

    public function checkToken(Request $request)
    {
        // $token = $request->header('Authorization');
        // $token = substr($token, strpos($token, "Bearer") + 7); 
        
        // $user = User::where('remember_token',$token)->first();
        
        // if($user){
            
        //     return $this->sendResponse(new UsersTokenResource($user), 'user login successfully');
        // }
        // else{
        //     return $this->sendError([],'Token is expired');
        // }

        // if(!auth()->check()){
        //     return $this->sendError([],'Token is expired');
        // }

        if($request->header('Authorization')){
            $token =  PersonalAccessToken::findToken($request->header('Authorization'));
            $user = $token?$token->tokenable:null;
            if($user){
              return $this->sendResponse(new UsersTokenResource($user), 'user login successfully');
              
            } 
            else{
              return $this->sendError([],'Token is expired');
            }
            
        }
        else{
            return $this->sendError([],'Token is expired');
        }
      
    }

    
}
