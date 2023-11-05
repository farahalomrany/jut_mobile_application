<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMessage;
class UserMessageController extends Controller
{
    public function answermessage($id)
    {
        $message = UserMessage::find($id);
        if($message->status == "read" || $message->status == "ignored"){
            $message->status = "answered";
            $message->save();

            return back()->with([
                'message'    => "this message status be answered",
                'alert-type' => 'success',
            ]);
        }
        else{
            return back()->with([
                'message'    => "this message status must be read or ignored",
                'alert-type' => 'error',
            ]);
        }
       
    }
    public function ignoremessage($id)
    {
        $message = UserMessage::find($id);
        if($message->status == "read"){
            $message->status = "ignored";
            $message->save();
            
             return back()->with([
            'message'    => "this message status be ignore",
            'alert-type' => 'success',
           ]);
        }
        else{
            return back()->with([
            'message'    => "this message must be read",
            'alert-type' => 'error',
        ]); 
        }
       
        // return redirect()->route("voyager.user-messages.index");
    }
}
