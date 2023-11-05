<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageJob implements ShouldQueue
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

        $User = "aec259";

        $From = "AEC";

        $Pass = "cea121519";
       
        $Lang = 0;
        $Gsm = $this->details['gsm'];
        $Msg = $this->details['msg'];

        
        $url="https://services.mtnsyr.com:7443/general/MTNSERVICES/ConcatenatedSender.aspx?User=".$User."&Pass=".$Pass."&From=".$From."&Gsm=".$Gsm."&Msg=".$Msg."&Lang=".$Lang;
       
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
