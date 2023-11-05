<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Member;
use App\Models\CityInx;
use Image;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Users\UsersResource;
use Illuminate\Http\Request;
use App\Http\Resources\Users\UsersWithDetailsResource;
use App\Http\Resources\Users\UsersWithDetailsProfileResource;
use App\Http\Resources\Users\UsersWithDetailsChangePassResource;

class ProfileController extends BaseController
{

    //update user profile
    public function profile(Request $request)
    { 
      
        $user_id = Auth()->user()->id;
        
        $input = $request->all();
      
        $validator = Validator::make($input, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city_id' => 'exists:cities_inx,id',
            'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'fstName' => 'string|min:2|max:32',
            'lstName' => 'string|min:2|max:32',
            'work' => 'in:painter,contractor,engineer,workshop_owner',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }
        
        $user = User::where('id',$user_id)->first();
       
        if($user){
           
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

            if (isset($input['fstName'])) {
                
                $user->fstName = $input['fstName'];
            }

            if (isset($input['work'])) {
                $member = Member::where('id',$user->userable_id)->first();
                if($member){
                    $member->work = $input['work'];
                    $member->save();
                }
                
            }

            if (isset($input['lstName'])) {
               
                $user->lstName = $input['lstName'];
            }

            if (isset($input['city_id'])) {
                
                $distributor = User::where('id',$user_id)->where('userable_type',"distributor")->first();
                
                if($distributor){
                    
                    $city = CityInx::where('id',$input['city_id'])->first()->name;
                    $distributor->userable->address = $city ;
                    $distributor->userable->save();
                }
            }

            // if (isset($input['phone'])) {
            
            //     $users = User::where('id',"!==",$user_id)->where('phone_number',$input['phone_number'])->get();
            //     if(count($users) > 0){
            //         return $this->sendError([],"The phone number has already been taken.");
            //     }
            //     else{

            //          // Six digits random number
            //         // $number = sprintf("%06d", mt_rand(1, 999999));

            //         // Call the same function if exists already
            //         // if ($this->isInviteNumberExists($number)) {
            //         //     return $this->generateInviteCode();
            //         // }

            //         // $user->code = $number;

            //         // $user->phone_verified_at = null;
            //         $user->phone_number = $input['phone_number'];
                    
            //     }
            // }
            
            $user->save();
            
            return $this->sendResponse(new UsersWithDetailsProfileResource($user),'profile has updated successfully.');

        }
        else{
            return $this->sendError([],"There is not profile for this user");
        }
    }

    //change password
    public function changePassword(Request $request)
    {
        
        $validator = Validator::make($request->all(),
            [
                'old_password' => ['required'],
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);

        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }

        $input = $request->all();
        
        $user = Auth()->user();
       
        $loginData = [];
        $loginData['phone_number'] = $user->phone_number;
        $loginData['password'] = $input['old_password'];
         
        //checking the old password first
        $check  = Auth::guard('web')->attempt([
                'phone_number' => $user->phone_number,
                'password' => $input['old_password']
        ]);

        if ($check) {
            $user->password = bcrypt($input['new_password']);

            // LogOut
            // $user->tokens()->delete();
            // $user->remember_token = '';

            $user->save();

            return $this->sendResponse(new UsersWithDetailsChangePassResource($user), 'Password Updated successfully.');

        }
        else{
            return $this->sendError([],'old Password is wrong.');
        }

        

    }

}
