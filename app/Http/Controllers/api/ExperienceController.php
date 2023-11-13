<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExperienceController extends Controller
{
    private function validate_data ($request){
        $validator = Validator::make($request-> all(), [
         'company' => 'required',
         'image' => 'required',
         'type' => 'required',
         'date_start' => 'required',
         'date_end' => 'required',
         'details' => 'required',
         'technologies' => 'required',
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


        $experience = new Experience;
        $experience->date_start = $request->input('date_start');
        $experience->company = $request->input('company');
        $experience->image = $request->input('image');
        $experience->type = $request->input('type');
        $experience->date_end = $request->input('date_end');
        $experience->details = $request->input('details');
        $experience->technologies = $request->input('technologies');
        $experience->save();
        return response()->json([
            'status'=>200,
            'message'=>'experience saved successfully', 
        ]);
    }  

    public function update (Request $request , $id){

        $validate = $this->validate_data($request);
      if($validate !== "") return $validate;

        $experience = Experience::find($id);
        if($experience){
           $experience->date_start = $request->input('date_start');
           $experience->company = $request->input('company');
           $experience->image = $request->input('image');
           $experience->type = $request->input('type');
           $experience->date_end = $request->input('date_end');
           $experience->details = $request->input('details');
           $experience->technologies = $request->input('technologies');
           $experience->save();
           return response()->json([
               'status'=>200,
               'message'=>'The experience has been modified successfully', 
           ]); 
        }
        else{
            return response()->json([
               'status'=>404,
               'message'=>'experience id not found', 
            ]);
        }
    }

    public function findById($id){
        $experience = Experience::find($id);

        if($experience)
        return response()->json(['status'=>200, 'project'=>$experience]); 

        return response()->json(['status'=>404,'message'=>'experience not found', ]); 
    }

    public function delete($id){
        $experience = Experience::find($id);
        if(!$experience)
         return response()->json([
            'status'=>404,
            'message'=>'experience id Non Trouver',
         ]); 
        $experience->delete();
    }
    

    public function findAll(){
        $experiences = Experience::all();
        return response()->json([
            'status'=>200,
            'data'=>$experiences,
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
