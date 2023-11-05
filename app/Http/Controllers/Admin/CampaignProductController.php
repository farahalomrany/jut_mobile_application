<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Campaign;
use App\Models\Distributor;
use App\Models\GiftNameInx;
use App\Models\Member;
use App\Models\Point;
use App\Models\Claim;
use App\Models\Gift;
use App\Models\AdminMessage;
use Carbon\Carbon;
use PDF;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Traits\CampaignTrait;
use App\Models\CampaignProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;

class CampaignProductController extends BaseController
{

    use CampaignTrait;
    public function campaign_products($id){

        $campaign = Campaign::find($id);
        //  dd($campaign);
        if($campaign) {
            
            
            return view('Admin.CampaignProduct' ,compact('campaign'));
            
        }

        return back()->with([
            'message'    => "campaign not found",
            'alert-type' => 'error',
        ]);
        
    }

    
    public function getProducts($id){

        $campaign = Campaign::find($id);
        $products = $campaign->products();

        $points = "";

        if(count($products)>0)
        {
            foreach($products as $product){

                $points = CampaignProduct::where('campaign_id',$id)->where('product_id',$product->id)->first()->points;
            }
            return view('Admin.products' ,compact('products','points'));

        }
        return redirect()->back()
        ->with([
            'message'    => "No Products",
            'alert-type' => 'error',
        ]);
    }

    public function get_all_campaigns(){

        $campaigns = Campaign::all();
      
        return view('Admin.campaigns' ,compact('campaigns'));
       
    }
    public function get_all_gifts_campaign($camp_id){
        $allGifts = [];
        $campaign = Campaign::where('id',$camp_id)->first();
        if($campaign){
            $claims = $campaign->claims;
            
            if(count($claims) > 0 ){
                foreach($claims as $claim){

                    $gifts = $claim->gifts;
                    foreach($gifts as $gift){
                        $giftNameInx = $gift->giftNameInx;
                        $allGifts[] = $giftNameInx;
                    }
                    return view('Admin.giftsCampaign' ,compact('allGifts','camp_id'));


                }

            }
            else{
                return redirect()->back()
                    ->with([
                        'message'    => "no claims",
                        'alert-type' => 'error',
                    ]);
            }

        }
        else{
            return redirect()->back()
                ->with([
                    'message'    => "campaign not exist",
                    'alert-type' => 'error',
                ]);
        }
      
       
    }
    
    
    public function getDistributors($id){

        $campaign = Campaign::find($id);
        
        if($campaign->distributors !== null){
            
            $dis = [];
            // $distributors[] = json_decode($campaign->distributors, true);
            
            foreach (json_decode($campaign->distributors, true) as $key => $value){
                
                $distributor_id = $value['id'];
                
                if(Distributor::where('id',$distributor_id)->first()){
                    $dis[] = Distributor::where('id',$distributor_id)->first();
                }
                
            }
            
            return view('Admin.distributors' ,compact('dis'));
        }

        return redirect()->back()
        ->with([
            'message'    => "No Distributors",
            'alert-type' => 'error',
        ]);
    }

    public function getGifts($id){

        $campaign = Campaign::find($id);
        
        if($campaign->giftsNames !== null){
            $giftsNames = $campaign->giftsNames;
            return view('Admin.gifts' ,compact('giftsNames'));
        }

        return redirect()->back()
        ->with([
            'message'    => "No Gifts",
            'alert-type' => 'error',
        ]);
    }

    public function add_product(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'player_id' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with([
                'message'    => 'Validation Error.'. $validator->errors(),
                'alert-type' => 'error',
            ]);
        }
        $player = PlayerInfo::find( $input['player_id']);
        $coach_info_id = $player->coach()->id;

        CoachPlayer::where('player_info_id', $input['player_id'])->where('coach_info_id',$coach_info_id)->delete();


        return redirect()->back()
            ->with([
                'message'    => "Deleted player",
                'alert-type' => 'success',
            ]);
    }

    public function getPagePoints(){

        $campaigns = Campaign::all();
      

        return view('Admin.campaignPoints' ,compact('campaigns'));

        
    }
    
    public function getPageMember(){

        $members = Member::all();
      

        return view('Admin.membersCampaign' ,compact('members'));

        
    }
    
    public function resetAll(){

        $points = Point::all();
        foreach($points as $point){
            $point->reset = 1;
            $point->save();
        }
        
        return redirect()->route("voyager.points.index");
      

        
    }
    

    public function getPageClaims(){

        $campaign_id = $this->current_campaign();
        $claims = [];
        if($campaign_id !== null){
           
            $campaign = Campaign::where('id',$campaign_id)->first();
            
            $now = Carbon::now()->toDateString();
            
            if($campaign){
                $gain_start_date = Carbon::parse($campaign->gain_start_date);
                
                $claims = [];
                if($gain_start_date->lte($now)){
                   
                    $claims = Claim::where('campaign_id',$campaign_id)->get();
    
                    return view('Admin.claims' ,compact('claims'));
                }
                
            }
            else{
                return back()->with([
                    'message'    => "There is not campaign now",
                    'alert-type' => 'error',
                ]);
            }
         
        }
        else{
            return view('Admin.claims' ,compact('claims'));
            // return back()->with([
            //     'message'    => "There is not campaign now",
            //     'alert-type' => 'error',
            // ]);
        }
     

        
    }

    public function refuse($id){

        $claim = Claim::where('id',$id)->where('status',"new")->first();
        if($claim){

            $claim->status = "refused";
            $claim->save();
            return back()->with([
                'message'    => "Claim has been refused successfully",
                'alert-type' => 'success',
            ]);
        }
        else{
            return back()->with([
                'message'    => "Sorry,this claim must be in new status",
                'alert-type' => 'error',
            ]);
        }
       
        
    }

    public function acceptPage($id)
    {
        //gifts 
        $claim = Claim::where('id',$id)->first();
        if($claim){
         if($claim->status == "new"){
            $gifts = [];
            $points_gift = [];
            $campaign_id = $claim->campaign_id;
            $member_id  = $claim->member_id;
            $current_campaign_id = $this->current_campaign();
             if($current_campaign_id !== null){
                $campaign = Campaign::where('id',$current_campaign_id)->first();
                if($campaign){
                    $giftsNames = $campaign->giftsNames;
                    
                    $member = Member::where('id',$member_id)->first();
                    $member_points = $member->count_points_for_member_in_campaign($campaign_id,$member_id);
                    if($giftsNames !== null){
                        foreach (json_decode($giftsNames ,true) as $key => $value){

                            $points = $value['points'];
                            if($points == $member_points || $points < $member_points){
                                $gift_id = $value['id'];
                            
                                $gift = GiftNameInx::where('id',$gift_id)->first();
                                if($gift){
                                    $gifts[] = $gift;
                                }
        
                                $points_gift[] = $points;
                            
                            }
                        }
                    }
                    
                }

             }
             else{
                return back()->with([
                    'message'    => "Sorry,Now campaign now!!",
                    'alert-type' => 'error',
                ]);
            }
                    
        }
        else{
            return back()->with([
                'message'    => "Sorry,this claim must be in new status",
                'alert-type' => 'error',
            ]);
        }
        }
        $claim_id = $claim->id;
        return view('Admin.acceptClaimPage',compact('gifts','claim_id','current_campaign_id','member_points','points_gift'));
    }

    public function setGift(Request $request)
    {
        
        $input = $request->all();
        $claim_id = $input['claim_id'];
        $campaign_id = $input['current_campaign_id'];
        $is_available = 0;
        $member_id  = Claim::where('id',$input['claim_id'])->first()->member_id ;
        $giftsNames = Campaign::where('id',$input['current_campaign_id'])->first()->giftsNames;

        $member  = Member::where('id',$member_id)->first();
        $member_points = $member->count_points_for_member_in_campaign($campaign_id,$member_id);
        
        foreach($input['program_ids'] as $gift_id){

            foreach (json_decode($giftsNames ,true) as $key => $value){

                if($value['id'] == $gift_id){

                    $points = $value['points'];
                    $is_available += $points;

                    if($is_available < $member_points ||$is_available == $member_points){

                        $gift = new Gift();
                        $gift->gift_name_inx_id = $gift_id;
                        $gift->claim_id = $claim_id;
                        $gift->date = Carbon::now()->toDateString();
                        $gift->save();
         
        
                   }
                   else{
                    return back()->with([
                        'message'    => "Member's points not enough",
                        'alert-type' => 'error',
                    ]);
                   }
                }

            }
    
         
        
        
        }
        return back()->with([
            'message'    => "Gift has been given to member successfully",
            'alert-type' => 'success',
        ]);

    }

    public function givenGifts(Request $request)
    {
        $current_campaign_id = $this->current_campaign();
        
        if($current_campaign_id !== null){

            $giftNameInxs = [];
            $gifts = Gift::all();
           
            foreach($gifts as $gift){
                $claim_id  = $gift->claim_id;
               
                $claim = Claim::where('id',$claim_id)->first();
                if($claim){
                    $campaign_id  = $claim->campaign_id;
                   
                    if($campaign_id == $current_campaign_id){
                       
                        $giftNameInxs[] = $gift->giftNameInx;
                        
                    }
                }
            }
            return view('Admin.givenGifts' ,compact('giftNameInxs'));

        }
        else{
            return redirect()->back()
                ->with([
                    'message'    => "No campaign now!!",
                    'alert-type' => 'error',
                ]);
        }
    

    }

    public function ownAdminMessages(){

        $messages = AdminMessage::where('admin_id',auth()->user()->id)->get();
       
        return view('Admin.ownMessages' ,compact('messages'));

        // return redirect()->route("voyager.admin-messages.index");
      

        
    }
    
    public function deleteMessage($id){

        $claim = Claim::where('id',$id)->where('status',"new")->first();
        if($claim){

            $claim->status = "refused";
            $claim->save();
            return back()->with([
                'message'    => "Claim has been refused successfully",
                'alert-type' => 'success',
            ]);
        }
        else{
            return back()->with([
                'message'    => "Sorry,this claim must be in new status",
                'alert-type' => 'error',
            ]);
        }
        
    }

    public function viewMessage($id){

        $message = AdminMessage::where('id',$id)->first();
        if($message){

            // return redirect()->route("voyager.admin-messages.index/" .$message->id);
            return redirect('admin/admin-messages/' . $message->id);
         
        }
      
    }

    

    public function deleteMessages(){

        $adminMessages = AdminMessage::all();
        foreach($adminMessages as $adminMessage){
            $adminMessage->delete() ;
            
        }
        
        return redirect()->route("voyager.admin-messages.index");
      

        
    }

    public function setPoint(Request $request)
    {
        $campaign_id = $request->input('campaign_id');
        $member_id = $request->input('member_id');
        $member = Member::where('id',$member_id)->first();
        $points = 0;
        $bills = $member->bills;
        if(count($bills) > 0){
            $points = $member->count_points_for_member_in_campaign($campaign_id,$member_id);
        }
        
        return $points;
        
    }

    public function getPageMemberPoints($id,Request $request){

        $members = Member::all();
        $campaign_id = $id;
        
        return view('Admin.campaignMembers' ,compact('members','campaign_id'));
 
    }

    public function exportPdf(Request $request,$campaign_id)  
    {  
       
        $members = Member::all();
       
        view()->share('members',$members,'campaign_id',$campaign_id);  

        $pdf = PDF::loadView('Admin.allPoints',['campaign_id' => $campaign_id])->setOptions(['defaultFont' => 'sans-serif']);  
            
        return $pdf->download('itemPdfView.pdf');  
         
    } 

    public function exportPdfGifts($id)  
    {  
        
        $allGifts = [];
        $campaign = Campaign::where('id',$id)->first();
        
        if($campaign){
            $claims = $campaign->claims;
          
            if(count($claims) > 0 ){
                foreach($claims as $claim){

                    $gifts = $claim->gifts;
                    
                    foreach($gifts as $gift){
                        $giftNameInx = $gift->giftNameInx;
                        $allGifts[] = $giftNameInx;
                    }
                    
                    view()->share('allGifts',$allGifts);  

                    $pdf = PDF::loadView('Admin.allGifts')->setOptions(['defaultFont' => 'sans-serif']);  
            
                    return $pdf->download('gifts.pdf');  

                }

            }
            else{
                return redirect()->back()
                    ->with([
                        'message'    => "no claims",
                        'alert-type' => 'error',
                    ]);
            }

        }
         
    } 

    //Excel points
    public function export(Request $request) 
    {
       
        return Excel::download(new ExportPoints($request->id), 'points.xlsx');
    }

    //Excel gifts
    public function exportExcelGifts(Request $request) 
    {
       
        return Excel::download(new ExportGifts($request->id), 'gifts.xlsx');
    }

}

//Excel points
class ExportPoints implements FromCollection
{

    protected $id;

    function __construct($id) {

            $this->id = $id;
            
    }

    public function collection()
    {
        $members =  Member::all()->makeHidden(['created_at','updated_at']);
    
      
            foreach($members as $member){
                
                $mm = $members->map(function ($member, $key){
                   
                    $point = $member->count_points_for_member_in_campaign($this->id , $member->id);
                    if($point == 0){
                        $point = "point is zero";
                    }else{
                        $point = $point;
                    }
                   
                     $c = $member;
                     $c['points'] = $point;
                    
                     return $c;
              
               });

            }
          
        return $mm;
      
    }

}
//Excel gifts
class ExportGifts implements FromCollection
{

    protected $id;

    function __construct($id) {

            $this->id = $id;
            
    }

    public function collection()
    {
        
        $allGifts = [];
        $campaign = Campaign::where('id',$this->id)->first();
       
        if($campaign){
           
            $claims = $campaign->claims;
            
            if(count($claims) > 0 ){
                foreach($claims as $claim){

                    $gifts = $claim->gifts;
                    
                    foreach($gifts as $gift){
                        $giftNameInx = $gift->giftNameInx->makeHidden(['image','created_at','updated_at']);
                        $allGifts[] = $giftNameInx;

                    }
                   
                }
              
                 return collect($allGifts);
             

            }
            else{
                return redirect()->back()
                    ->with([
                        'message'    => "no claims",
                        'alert-type' => 'error',
                    ]);
            }

        }
      
    }

}
