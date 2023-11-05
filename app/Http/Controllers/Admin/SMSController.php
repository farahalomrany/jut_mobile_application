<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\Users\UsersWithDetailsResource;
use App\Http\Resources\Users\UsersTokenResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Users\UsersResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Http;


class SMSController extends BaseController
{

    
  
    public function syriatel(Request $request){

        $msg = "hi mrmr";
        $to = "963992303651";
     

        $response = Http::post('http://192.168.1.118/sendsyriatelmessage', [
            'msg' => $msg,
            'to' => $to,
        ]);

        return $response->json();
        //#2

            // $client = new Client();
            // $response = $client->post('http://192.168.1.118/sendsyriatelmessage', [
            //     'verify'    =>  false,
            //     'form_params' => [
            //         'msg' => $msg,
            //         'to' => $to,
                
            //     ],
            // ]);
            

        //#3

            //     $apiURL = 'http://192.168.1.118/sendsyriatelmessage';
            //     $postData = [
            //              'msg' => $msg,
            //              'to' => $to,
                        
            //            ];
                        
            //    $client = new \GuzzleHttp\Client();
            
            //    $response = $client->request('POST', $apiURL, ['form_data' =>$postData]);
                
            //    $responseBody = json_decode($response->getBody(), true);
       
       
   
    }

    public function doo()
    {

        $msg="manar2";
        $num="963992303651";
        $num="963948858334";
       
        $url="https://services.mtnsyr.com:7443/general/MTNSERVICES/ConcatenatedSender.aspx?User=aec259&Pass=cea121519&From=AEC&Gsm=963948858334&Msg=aaa&Lang=0";

        $ch = curl_init();
              curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
              curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
              curl_setopt ($ch, CURLOPT_AUTOREFERER, true);
              curl_setopt($ch, CURLOPT_HEADER, 0);
              curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        try{
                curl_setopt($ch, CURLOPT_URL,$url);
                $output = curl_exec($ch);
                
                if (curl_errno($ch)) {
                    $isError = true;
                    $errorMessage = curl_error($ch);
                }
                curl_close($ch);
                
                if($isError){
                   return array('error' => 1 , 'message' => $errorMessage);
                }else{
                    return array('error' => 0 );
                }
                
        }catch (GuzzleException $e) {
           return $e->getMessage();
        }
     
    }
    
    

    public function doo5000(){

         $apiURL = 'https://bms.syriatel.sy/API/SendSMS.aspx';
         $postData = [
                  'user_name' => 'aecmobile1',
                  'password' => 'P@1234567',
                  'msg' => "test solved",
                  'sender' => "aecmobile",
                  'to' => '963932701667'
                ];
                        
        $client = new \GuzzleHttp\Client();
       
        $response = $client->request('POST', $apiURL, ['form_params' =>$postData]);
         return "erg";
       $responseBody = json_decode($response->getBody(), true);
    
       dd($responseBody);
      
    //   $postData = array(
    //       'user_name' => 'aecmobile1',
    //       'password' => 'P@1234567',
    //       'msg' => "test solved",
    //       'sender' => "aecmobile",
    //       'to' => '963932701667'
          
    //   );

 
    //   $url = "https://bms.syriatel.sy/API/SendSMS.aspx?";
     
    //   $ch = curl_init();
      
    //   curl_setopt_array($ch, array(
    //     CURLOPT_URL => $url,
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_POST => true,
    //     CURLOPT_POSTFIELDS => $postData
    //   ));
    
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //     if(curl_exec($ch) === false)
    //     {
    //       echo 'Curl error: ' . curl_error($ch);
    //     }
        // else
        // {
           //echo 'Operation completed without any errors';
        // }
        // curl_close($ch);
        

    }

    public function doo1(){
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
        "https://bms.syriatel.sy/API/SendSMS.aspx?user_name=aecmobile1&password=P@1234567&msg=test&sender=aecmobile&to=963992303651");

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if(curl_exec($ch) === false)
        {
        echo 'Curl error: ' . curl_error($ch);
        }
        // else
        // {
        // echo 'Operation completed without any errors';
        // }
        curl_close($ch);
    }
     

    public function doo99()
    {
        
      
        $client = new Client();
     
        $response = $client->post('https://services.mtnsyr.com:7443/general/MTNSERVICES/ConcatenatedSender.aspx?', [
            'verify'    =>  false,
            'form_params' => [
                'User' => "aec259",
                'Pass' => "cea121519",
                'From'=> "AEC",
                'Gsm' =>"963948858334",
                'Msg' => "aaa",
                'Lang' => 1,
            ],
        ]);
        
        return "hi2";

        $response = json_decode($response->getBody(), true);
        return $response ;
    }

    public function initiateSmsActivation(){
        $isError = 0;
        $errorMessage = true;

        //Preparing post parameters
        $postData = array(
            'User' => "aec259",
            'Pass' => "cea121519",
            'From'=> "AEC",
            'Gsm' =>"963948858334;963932701667;",
            'Msg' => "06270628062a",
            'Lang' => 1,
        );

        $url = "https://services.mtnsyr.com:7443/general/MTNSERVICES/ConcatenatedSender.aspx?";

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }
        curl_close($ch);

        if($isError){
            return array('error' => 1 , 'message' => $errorMessage);
        }else{
            return array('error' => 0 );
        }
    }
   
    
}
