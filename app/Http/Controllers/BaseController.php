<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'status_code' => 200,
            'errors' => [
                
            ],
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    // public function sendError($error, $errorMessages = [], $code = 404)
    // {
    // 	$response = [
    //         'success' => false,
    //         'message' => $error,
    //         'status_code' => 404,
    //     ];


    //     if(!empty($errorMessages)){
    //         $response['data'] = $errorMessages;
    //     }

    //     return response()->json($response, $code);
    // }

    public function sendError($result, $message)
    {
    	$response = [
            'success' => false,
            'data'    => (object)$result,
            'status_code' => 404,
            'errors' => [
                $message,
            ],
            
        ];


        return response()->json($response, 200);
    }

    public function sendErrorLogin($result, $message)
    {
    	$response = [
            'success' => false,
            'data'    => (object)$result,
            'status_code' => 406,
            'errors' => [
                $message,
            ],
            
        ];


        return response()->json($response, 406);
    }


    // api save device token
    public function sendNotification($user ,$body)
    {

        $SERVER_API_KEY = 'AAAAmKcgnwE:APA91bGdl2h9yyHYX3bopKv-K3gV8ksZD-y_gBXvdHGsDaNK3DK3xEBXIEL_8G1LP15cnerEX_1GjPAecdjG-NURRNROA_OPRDCZOZ0lfCsbJgO8ikLM77r0wCfZZYvE8x4xDZA1GwXZ';

            $data = [

                "registration_ids" => [$user->device_token],

                "notification" => [

                    "body" => $body,  

                ]

            ];

            $dataString = json_encode($data);

            $headers = [

                'Authorization: key=' . $SERVER_API_KEY,

                'Content-Type: application/json',

            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            return response()->json($response);

    }
    
}