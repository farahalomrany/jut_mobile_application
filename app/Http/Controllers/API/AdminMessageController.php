<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\Distributor;
use App\Models\Member;
use App\Models\Product;
use App\Models\AdminMessage;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Products\ProductDetailResource;
use App\Http\Resources\UserMessage\AdminMessageResource;
use Illuminate\Http\Request;

class AdminMessageController extends BaseController
{
    //get all messages 
    public function messages()
    {
        $userable_type = Auth()->user()->userable_type;
        $userable_id = Auth()->user()->userable_id;
        $user_id = Auth()->user()->id;

        if ($userable_type == "member") {
            $member = Member::where('id', '=', $userable_id)->first();
            $admin_messages = [];
            $messages = AdminMessage::all();
            foreach ($messages as $admin_message) {
                $destination = $admin_message->destination;
                $receivers = $admin_message->receivers;
                foreach (json_decode($destination, true) as $key => $value) {
                    if ($value['name'] == "members") {
                        foreach (json_decode($receivers, true) as $key => $value) {
                            if ($value['id'] == 'All') {
                                $admin_messages[] = $admin_message;
                            } else {
                                if (strtolower($value['id']) == $member->classification) {
                                    $admin_messages[] = $admin_message;
                                }
                            }

                        }
                    }
                }
            }
            $data['messages'] = AdminMessageResource::collection($admin_messages);
            return $this->sendResponse($data, 'messages retrived successfully.');
        }

        if ($userable_type == "observer") {

            $admin_messages = [];
            $messages = AdminMessage::all();

            foreach ($messages as $admin_message) {
                $destination = $admin_message->destination;
                foreach (json_decode($destination, true) as $key => $value) {
                    if ($value['name'] == "observers") {
                        if ($value['id'] == 'All') {
                            $admin_messages[] = $admin_message;
                        } else {
                            if ($value['id'] == $user_id) {
                                $admin_messages[] = $admin_message;
                            }
                        }

                    }
                }
            }

            $data['messages'] = AdminMessageResource::collection($admin_messages);
            return $this->sendResponse($data, 'messages retrived successfully.');
        }

        if ($userable_type == "distributor") {
            $distributor = Distributor::where('id', '=', $userable_id)->first();

            $admin_messages = [];
            $messages = AdminMessage::all();
            foreach ($messages as $admin_message) {
                $destination = $admin_message->destination;
                foreach (json_decode($destination, true) as $key => $value) {
                    if ($value['name'] == "distributors") {
                        if ($value['id'] == 'All') {
                            $admin_messages[] = $admin_message;
                        } else {
                            if ($value['id'] == $distributor->address) {
                                $admin_messages[] = $admin_message;
                            }
                        }

                    }
                }
            }

            $data['messages'] = AdminMessageResource::collection($admin_messages);
            return $this->sendResponse($data, 'messages retrived successfully.');
        } else {
            return $this->sendError([], "error");
        }
    }




}