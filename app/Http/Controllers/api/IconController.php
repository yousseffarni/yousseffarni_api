<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Icon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IconController extends Controller
{
    private function validate_data ($request){
      $validator = Validator::make($request-> all(), [
       'name' => 'required',
       'icon' => 'required',
      ]);
      
      if($validator->fails())
       return response()->json([
         'validation_errors'=>$validator->messages(),
         'message'=>$validator->messages(),
       ]);
       
      return "";
    }

    public function add (Request $request){

      $validate = $this->validate_data($request);
      if($validate !== "") return $validate;

      $icon = new Icon;
      $icon->name = $request->input('name');
      $icon->icon = $request->input('icon');
      $icon->save();
      return response()->json([
          'status'=>200,
          'message'=>'icon saved successfully', 
      ]);
    }  

    public function update (Request $request , $id){

        $validate = $this->validate_data($request);
        if($validate !== "") return $validate;

        $icon = Icon::find($id);
        if($icon){
           $icon->name = $request->input('name');
           $icon->icon = $request->input('icon');
           $icon->save();
           return response()->json([
               'status'=>200,
               'message'=>'The icon has been modified successfully', 
           ]); 
        }
        else{
            return response()->json([
               'status'=>404,
               'message'=>'icon id not found', 
            ]);
        }
    }

    public function findById($id){
        $icon = Icon::find($id);

        if($icon)
        return response()->json(['status'=>200, 'icon'=>$icon]); 

        return response()->json(['status'=>404,'message'=>'icon not found', ]); 
    }

    public function delete($id){
        $icon = Icon::find($id);
        if(!$icon)
         return response()->json([
            'status'=>404,
            'message'=>'icon id Non Trouver',
         ]); 
        $icon->delete();
    }
    

    public function findAll(){
        $icons = Icon::all();
        return response()->json([
            'status'=>200,
            'data'=>$icons,
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
