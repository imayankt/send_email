<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function userLogin(Request $request)
    {
        $input = $request->all();
        $vallidation = Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($vallidation->fails()){
            return response()->json(['status'=>false,
                                     'message'=>'Required fields are missing',
                                     'error' => $vallidation->errors(),'data'=>[]],422);
        }
        
        if (Auth::attempt(['email' => $input['email'],'password' => $input['password']])) {

            $user  = Auth::user();

            $token = $user->createToken('Salting')->accessToken;

            return response()->json(['status'=>true,'message' =>'Login successfully',"data"=>['token' => $token]],200);
        }
        else{
            return response()->json(['status'=>false,'message' => 'Invaid username or password','data'=>[]],'401');

        }
    }

   public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
                'name' => 'required', 
                'email' => 'required|email|unique:users,email', 
                'password' => 'required|confirmed',
            ]);
            
        if ($validator->fails()) { 
            return response()->json(['status'=>false,'message'=>'Required fields are missing',
                                    'error'=>$validator->errors(),'data'=>[]], 422);            
        }
            
        $input = $request->all();
            
        $input['password'] = bcrypt($input['password']); 
                        
        $user = User::create($input); 

        $data['token'] =  $user->createToken('Salting')->accessToken;
        $data['name'] =  $user->name;

        return response()->json(['status'=>true,'message' =>'Register successfully','data'=>$data], 200); 
    }

    public function logout (Request $request) {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json([
              'status' => true,
              'message' => 'Logout successfully',
              'data'=>[]
          ],200);
          }else {
            return status()->json([
              'success' => false,
              'message' => 'Unable to Logout',
              'data'=>[]
            ],200);
          }
    }
}
