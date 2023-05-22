<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserEmail;
use App\Jobs\SendEmailJob;
use Validator;
use Auth;

class EmailController extends Controller
{
    public function getEmailList(){
        try{
            
            $data = UserEmail::where('user_id', Auth::id())
                     ->orderBy('id')
                     ->get()
                     ->toArray();

            if(!empty($data)){
                return response()->json(['status'=>true,'message' =>'Success','data'=>$data], 200);
            }

            return response()->json(['status'=>false,'message' =>'No Data','data'=>[]], 200);

        }catch(\Exception $e){

            return response()->json(['status'=>false,'message' =>'Something went wrong','data'=>[]], 500);
        }
        
    }

    public function sendEmail(Request $requests){
        try{

            $validator = Validator::make($requests->all(), [ 
                'subject' => 'required', 
                'email' => 'required|email', 
                'content' => 'required',
            ]);
            
            if ($validator->fails()) { 
                return response()->json(['status'=>false,'message'=>'Required fields are missing','data'=>[],'error'=>$validator->errors()], 422);            
            }
            $data = $requests->all();

            //Create entry in table
            $arr = ['user_id'=>Auth::id(),
                    'subject'=> $data['subject'],
                    'content' => $data['content'],
                    'receiver_email' => $data['email'],
                    'status' => 'processing'
                    ];
            $insert = UserEmail::create($arr);
            
            $data['user_email_id'] = $insert->id;

            dispatch(new SendEmailJob($data));

            return response()->json(['status'=>true,'message' =>'Processing mail','data'=>[]], 200);

        }catch(\Exception $e){

            return response()->json(['status'=>false,'message' =>'Something went wrong','data'=>[]], 500);
        }
        
    }
}
