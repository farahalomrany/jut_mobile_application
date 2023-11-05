<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageSyriatelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ch = curl_init();

        $user_name = "aecmobile1";
        $password =  "P@1234567";
        $sender = "aecmobile";

        $msg = urlencode($this->details['msg']);
        $to = urlencode($this->details['to']);
        
        $url="https://bms.syriatel.sy/API/SendSMS.aspx?user_name=".$user_name."&password=".$password."&msg=".$msg."&sender=".$sender."&to=".$to;
        curl_setopt($ch, CURLOPT_URL,$url);

        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $res= curl_exec($ch);
        $err=curl_error($ch);
    
        curl_close($ch);

        if($res){
            return true;
        }
        else{
            return false;
        }
    
    }
}
