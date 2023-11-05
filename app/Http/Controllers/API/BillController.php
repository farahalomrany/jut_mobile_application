<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Observer;
use App\Models\Distributor;
use App\Http\Resources\Bills\BillResource;
use App\Http\Resources\Bills\BillForDistributorResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class BillController extends BaseController
{

    public function upload_bill(Request $request)
    {
        
        $user_id = Auth()->user()->userable_id;
       
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }
        
        if ($request->file('image')) {
            
            $bill = new Bill();
            
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            
            $filename = uniqid() . '.png';

            $now = Carbon::now()->format('MY');
            
            $filePath = "bills/" . $now . "/" . $filename;
           
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
                
                $bill->bill_image = $filePath;
            }
            
            $bill->member_id  = $user_id;
            
            $bill->upload_date = Carbon::now();
           
            $bill->save();
           
            return $this->sendResponse(new BillResource($bill),'Bill has uploaded successfully.');
           
        }
       

    }

    public function bills_app1(Request $request)
    {
        
        $user_id = Auth()->user()->userable_id;
        $billswithfilter = [];
        $bills = [];
        if(Auth()->user()->userable_type == "member"){
          
            $bills = Bill::where('member_id',$user_id)->get();
            if(count($bills) > 0){

                foreach($bills as $bill){
                    if(count($bill->products()) > 0 && $bill->insert_date !== null && $bill->distributor_id  !== null){
                                
                        $bills[] = $bill; 
                    }
                }

            }
                    
            if(isset($request->filters['upload_date']) && !isset($request->filters['distributor_id'])){
                
                if(count($bills) > 0){
                    
                    foreach($bills as $bill){
                    
                        $upload_date = Carbon::parse($bill->upload_date)->toDateString();
                        if($upload_date == $request->filters['upload_date'] ){
                            
                            if(count($bill->products()) > 0 && $bill->insert_date !== null && $bill->distributor_id  !== null){
                                
                                $billswithfilter[] = $bill; 
                            } 
                        }
                    } 
                } 
                $data['bills']    = BillResource::collection($billswithfilter);
                return $this->sendResponse($data, 'Bills retrived successfully.');
            }
            if(isset($request->filters['distributor_id']) ){
                if(isset($request->filters['upload_date'])){

                    if(count($bills) > 0){
                        foreach($bills as $bill){
                               $upload_date = Carbon::parse($bill->upload_date)->toDateString();
                               if($bill->distributor_id == $request->filters['distributor_id'] && $upload_date == $request->filters['upload_date']){
                                if(count($bill->products()) > 0 && $bill->insert_date !== null && $bill->distributor_id  !== null){
                                
                                    $billswithfilter[] = $bill; 
                                } 

                               }
                           
                        }                 
                }
                $data['bills']    = BillResource::collection($billswithfilter);
                return $this->sendResponse($data, 'Bills retrived successfully.');

                }
                else{
                    if(count($bills) > 0){
                        foreach($bills as $bill){
                               if($bill->distributor_id == $request->filters['distributor_id']){
                                if(count($bill->products()) > 0 && $bill->insert_date !== null && $bill->distributor_id  !== null){
                                
                                    $billswithfilter[] = $bill; 
                                } 

                               }
                           
                        }                 
                    }
                }
                
                $data['bills']    = BillResource::collection($billswithfilter);
                return $this->sendResponse($data, 'Bills retrived successfully.');
            }

            $data['bills']    = BillResource::collection($bills);
            return $this->sendResponse($data, 'Bills retrived successfully.');
        }

    }

    public function bills_app1_sales(Request $request)
    {
        
        $user_id = Auth()->user()->userable_id;
        $billswithfilter = [];
        $bills = [];
        if(Auth()->user()->userable_type == "distributor"){
            
          
            $bills = Bill::where('distributor_id',$user_id)->get();
            if(count($bills) > 0){
                foreach($bills as $bill){
                    if(count($bill->products()) > 0 && $bill->insert_date !== null){
                                
                        $bills[] = $bill; 
                    } 
                }
            }
                    
            if(isset($request->filters['upload_date']) && !isset($request->filters['distributor_id'])){
            
                if(count($bills) > 0){
                    
                    foreach($bills as $bill){
                    
                        $upload_date = Carbon::parse($bill->upload_date)->toDateString();
                        if($upload_date == $request->filters['upload_date'] ){
                            
                            if(count($bill->products()) > 0 && $bill->insert_date !== null){
                                
                                $billswithfilter[] = $bill; 
                            } 
                        }
                    } 
                } 
                $data['bills']    = BillForDistributorResource::collection($billswithfilter);
                return $this->sendResponse($data, 'Bills retrived successfully.');
            }
            if(isset($request->filters['distributor_id']) ){
                if(isset($request->filters['upload_date'])){
                 
                  if(count($bills) > 0){
                    foreach($bills as $bill){
                       
                           $upload_date = Carbon::parse($bill->upload_date)->toDateString();
                           if($bill->distributor_id == $request->filters['distributor_id'] && $upload_date == $request->filters['upload_date']){
                            if(count($bill->products()) > 0 && $bill->insert_date !== null && $bill->distributor_id  !== null){
                            
                                $billswithfilter[] = $bill; 
                            } 

                           }
                            
                            }                 
                    }
                    $data['bills']    = BillForDistributorResource::collection($billswithfilter);
                    return $this->sendResponse($data, 'Bills retrived successfully.');

                }
                else{
                    if(count($bills) > 0){
                        foreach($bills as $bill){
                           if($bill->distributor_id == $request->filters['distributor_id']){
                            if(count($bill->products()) > 0 && $bill->insert_date !== null){
                            
                                $billswithfilter[] = $bill; 
                            } 

                           }
                       
                        }                 
                    }
                    $data['bills']    = BillForDistributorResource::collection($billswithfilter);
                    return $this->sendResponse($data, 'Bills retrived successfully.');
                }
            }
            $data['bills']    = BillForDistributorResource::collection($bills);
            return $this->sendResponse($data, 'Bills retrived successfully.');
        }

    }

    public function bills_app2(Request $request)
    {
        
        $user_id = Auth()->user()->userable_id;
        
        $all_bills= [];

        $observer = Observer::where('id',$user_id)->first();
        if($observer){
           
            $distributores = $observer->distributores();
           
            if(count($distributores) > 0){
                
                foreach($distributores as $distributor){
                   
                    $distributor_id = $distributor->id;
                    
                    $bills = Bill::where('distributor_id',$distributor_id)->get();
                     
                    if(count($bills) > 0){
                       
                        foreach($bills as $bill){
                          
                            if(count($bill->products()) > 0 ){
                                
                                $all_bills[] = $bill;
                              
                            }
    
                        
                        }

                    }
            
                }
                if(isset($request->filters['upload_date']) && !isset($request->filters['member_id'])){
                    $billswithuploaddate = [];
                    foreach($bills as $bill){
                        $upload_date = Carbon::parse($bill->upload_date)->toDateString();
                        if($upload_date == $request->filters['upload_date']){
                            $billswithuploaddate[] = $bill;
                        }               
                    }
                    $data['bills']    = BillResource::collection($billswithuploaddate);
            
                    return $this->sendResponse($data, 'Bills retrived successfully.');
                    
                }

                if(isset($request->filters['member_id'])){
                    $billswithuploaddate = [];
                    if(isset($request->filters['upload_date'])){
                        
                        foreach($bills as $bill){
                            $upload_date = Carbon::parse($bill->upload_date)->toDateString();
                            if($upload_date == $request->filters['upload_date'] && $bill->member_id == $request->filters['member_id']){
                                $billswithuploaddate[] = $bill;
                            }               
                        }
                        
                        $data['bills']    = BillResource::collection($billswithuploaddate);
                
                        return $this->sendResponse($data, 'Bills retrived successfully.');
                        
                    }
                    else{
                        foreach($bills as $bill){
                            
                            if($bill->member_id == $request->filters['member_id']){
                                $billswithuploaddate[] = $bill;
                            }               
                        }
                        $data['bills']    = BillResource::collection($billswithuploaddate);
                
                        return $this->sendResponse($data, 'Bills retrived successfully.');
                        
                    }
                   
                    $data['bills']    = BillResource::collection($billswithuploaddate);
            
                    return $this->sendResponse($data, 'Bills retrived successfully.');
                    
                }
            }
            
            $data['bills']    = BillResource::collection($all_bills);
            
            return $this->sendResponse($data, 'Bills retrived successfully.');
            
        }
    }

    function isCodeExists($code)
    {
        $code = Bill::where('bill_code', '=', $code)->first();

        if ($code === null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    // Make random invite code from 6 digits
    function generateCode() 
    {
             // 10  random charts
             $result = '';
             for ($i = 0; $i < 10; $i++) {
                 $result .= chr(rand(65, 90));
             }
             
           
             // Call the same function if exists already
             if ($this->isCodeExists( $result)) {
                 return $this->generateCode();
             }
            
             // otherwise, it's valid and can be used
             return $result;
    }

    //edit bill
    // public function edit_bill(Request $request)
    // { 
    //      $user_id = Auth()->user()->id;
         
    //      $input = $request->all();
       
    //      $validator = Validator::make($input, [
    //          'distributer_id' => 'exists:distributors,id',
    //          'bill_id' => 'exists:bills,id',
    //      ]);
        
    //      if ($validator->fails()) {
    //          return $this->sendError([],$validator->errors()->first());
    //      }
     
    //      $bill = Bill::where('id',$input['bill_id'])->first();
         
    //      if($bill){
            
    //          if (isset($input['distributer_id'])) {
                 
    //              $bill->distributer_id = $input['distributer_id'];
    //              $bill->admin_id = $user_id; //????
    //              $bill->save();

    //              return $this->sendResponse(new BillResource($bill),'Bill has updated successfully.');
    //          }

    //     }
    // }


    public function delete_bill(Request $request)
    {

        $user_id = Auth()->user()->id;

        $input = $request->all();

        $validator = Validator::make($input, [
            'bill_id' => 'required|exists:bills,id',
        ]);
       
        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first());
        }

        $bill_id = $input['bill_id'];
        $member_id = Auth()->user()->userable_id;
       
        $bill = Bill::where('id',$bill_id)->where('member_id',$member_id)->first();
        if($bill){

            $bill->delete();
            return $this->sendResponse([], 'bill deleted successfully');

        }
        else{
            return $this->sendError([],"You are not owner on this bill");
        }


    }
}