<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProfileInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileInfoController extends Controller
{
    private function validate_data ($request){
        $validator = Validator::make($request-> all(), [
          /*
         'user_id' => 'required',
         'title' => 'required|min:10|max:250',
         'description' => 'required|min:20|max:1000',
         'categorie' => 'required',
         */
         'type' => 'required',
         'title' => 'required',
         'value' => 'required',
         'icon' => 'required',
        ]);
       
        if($validator->fails())
         return response()->json([
           'validation_errors'=>$validator->messages(),
           'message'=>$validator->messages(),
         ]);
         
        return true;
    }

    public function add (Request $request){

        if(!$this->validate_data($request)) return;


        $profileInfo = new ProfileInfo;
        $profileInfo->type = $request->input('type');
        $profileInfo->title = $request->input('title');
        $profileInfo->value = $request->input('value');
        $profileInfo->icon = $request->input('icon');
        $profileInfo->save();
        return response()->json([
            'status'=>200,
            'message'=>'profileInfo saved successfully', 
        ]);
    }  

    public function update (Request $request , $id){

        if(!$this->validate_data($request)) return;

        $profileInfo = ProfileInfo::find($id);
        if($profileInfo){
           $profileInfo->type = $request->input('type');
           $profileInfo->title = $request->input('title');
           $profileInfo->value = $request->input('value');
           $profileInfo->icon = $request->input('icon');
           $profileInfo->save();
           return response()->json([
               'status'=>200,
               'message'=>'The profileInfo has been modified successfully', 
           ]); 
        }
        else{
            return response()->json([
               'status'=>404,
               'message'=>'profileInfo id not found', 
            ]);
        }
    }

    public function findById($id){
        $profileInfo = ProfileInfo::find($id);

        if($profileInfo)
        return response()->json(['status'=>200, 'project'=>$profileInfo]); 

        return response()->json(['status'=>404,'message'=>'profileInfo not found', ]); 
    }

    public function delete($id){
        $profileInfo = ProfileInfo::find($id);
        if(!$profileInfo)
         return response()->json([
            'status'=>404,
            'message'=>'profileInfo id Non Trouver',
         ]); 
        $profileInfo->delete();
    }
    

    public function findAll(){
        $profileInfos = ProfileInfo::all();
        return response()->json([
            'status'=>200,
            'data'=>$profileInfos,
        ]);
    }

    public function UploadImage(Request $request,$id)
    {
      $validator = Validator::make($request-> all(), [
        'image' => 'required|file|mimes:jpg,png,jpeg|max:2048', 
      ]);
         

      if($validator->fails())
        return response()->json([
          'status'=>422,
          'validation_errors'=>$validator->messages(),
          'message'=>$validator->messages(),
        ]);   
        
        $img = $request->image; 
        if($img){
          $user = Auth::user();

          $username  = $user->username;
          $extension = $img->getClientOriginalExtension();
          $ActualNme = $img->getClientOriginalExtension();
          $filename = $username.'.'.$extension;
          $img->move("Uploads/users/$username/images/", $filename);
          $img_url = "Uploads/users/$username/images/".$filename;

          /*$image = new PostImage;
          $image->image = $img_url;
          $image->save();

          return response()->json([
            'status'=>200,
            'img_id'=>$image->id,
            'message'=>'Photo Profile et Téléchatger avec succès', 
          ]);
          */
          
        }else{
          return response()->json([
            'status'=>404,
            'message'=>'Image File not found', 
          ]);
        }
    }
}
