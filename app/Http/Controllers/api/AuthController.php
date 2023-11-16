<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function checkingAuthenticated(){
      $user = Auth::user();
      if($user)
        return response()->json(['message'=>'Vous êtes authentifié','status'=>200],200);
       return response()->json(['message'=>'Vous n\'êtes pas authentifié','status'=>404]);
    }

    public function Login(Request $request)
    {
       $validator = Validator::make($request-> all(), [
        'username_email' => 'required|min:4|max:191',
        'password' => 'required|min:8|max:25'
       ]);

       if($validator->fails())
            return response()->json([
             'validation_errors'=>$validator->messages(),
             'message'=>"Username / email and password fields are required!"
            ]); 

        $user = User::where('username' , $request->username_email)
                     ->orWhere('email' , $request->username_email)->first();
        if($user){      
          if(Hash::check($request->password, $user->password)){ 
            $token =  $user->createToken($user->username.'_Token')->plainTextToken;
            
            return response()->json([
              'status'=>200,
              'token'=>$token,
              "user"=>$user,
              'message'=>'You are successfully logged in', 
            ]);
          }
        }

        return response()->json([
            'status'=>404,
            'message'=>'username or password is incorrect', 
        ]);
    }

    public function SignUp(Request $request)
    {
       $validator = Validator::make($request-> all(), [
        'name' => 'required|min:4|max:191',
        'image' => 'nullable',
        'email' => 'required|email|unique:users,email',
        'username' => 'required|min:4|max:190|unique:users,username',
        'password' => 'required|min:8|max:20',
       ]);

       if($validator->fails())
            return response()->json([
             'validation_errors'=>$validator->messages(),
             'message'=>""
            ]); 

    
        $user = new User;
        $user->name = $request->name;
        $user->image = $request->image;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return response() ->json([
            'status'=>200,
            'message'=>'Account created successfully', 
        ]);
    }

    public function Logout(){
      //auth()->user()->tokens()->delete();*
      auth('web')->logout();
      return response()->json([
        'status'=>200,
        'message'=>'Déconnecté avec succès', 
      ]);
    }

    public function findById($id){
        $user = User::find($id);

        if($user)
        return response()->json(['status'=>200, 'data'=>$user]); 

        return response()->json(['status'=>404,'message'=>'user not found']); 
    }

    public function delete($id){
        $user = User::find($id);
        if(!$user)
         return response()->json([
            'status'=>404,
            'message'=>'this user not found',
         ]); 
        $user->delete();
    }
    

    public function allUsers()
    {
        $Users = User::all();
        return response()->json([
            'status'=>200,
            'data'=>$Users,
        ]);
    }
}
