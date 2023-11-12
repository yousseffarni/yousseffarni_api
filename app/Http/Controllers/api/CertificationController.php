<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Certification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CertificationController extends Controller
{
    private function validate_data ($request){
        $validator = Validator::make($request-> all(), [
          /*
         'user_id' => 'required',
         'title' => 'required|min:10|max:250',
         'description' => 'required|min:20|max:1000',
         'categorie' => 'required',
         */
         'date_start' => 'required',
         'date_end' => 'required',
         'image' => 'required',
         'specialization' => 'required',
         'institute' => 'required',
         'description' => 'required',
         'link' => 'required',
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


        $certification = new Certification;
        $certification->date_start = $request->input('date_start');
        $certification->date_end = $request->input('date_end');
        $certification->image = $request->input('image');
        $certification->specialization = $request->input('specialization');
        $certification->institute = $request->input('institute');
        $certification->description = $request->input('description');
        $certification->link = $request->input('link');
        $certification->save();
        return response()->json([
            'status'=>200,
            'message'=>'certification saved successfully', 
        ]);
    }  

    public function update (Request $request , $id){

        if(!$this->validate_data($request)) return;

        $certification = Certification::find($id);
        if($certification){
           $certification->date_start = $request->input('date_start');
           $certification->date_end = $request->input('date_end');
           $certification->image = $request->input('image');
           $certification->specialization = $request->input('specialization');
           $certification->institute = $request->input('institute');
           $certification->description = $request->input('description');
           $certification->link = $request->input('link');
           $certification->save();
           return response()->json([
               'status'=>200,
               'message'=>'The certification has been modified successfully', 
           ]); 
        }
        else{
            return response()->json([
               'status'=>404,
               'message'=>'certification id not found', 
            ]);
        }
    }

    public function findById($id){
        $certification = Certification::find($id);

        if($certification)
        return response()->json(['status'=>200, 'project'=>$certification]); 

        return response()->json(['status'=>404,'message'=>'certification not found', ]); 
    }

    public function delete($id){
        $certification = Certification::find($id);
        if(!$certification)
         return response()->json([
            'status'=>404,
            'message'=>'certification id Non Trouver',
         ]); 
        $certification->delete();
    }
    

    public function findAll(){
        $certifications = Certification::all();
        return response()->json([
            'status'=>200,
            'data'=>$certifications,
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
