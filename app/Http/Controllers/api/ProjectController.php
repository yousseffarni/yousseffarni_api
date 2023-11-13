<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    private function validate_data ($request){
      $validator = Validator::make($request-> all(), [
       'type' => 'required',
       'name' => 'required',
       'image' => 'required',
       'technologies' => 'required',
       'link' => 'required',
       'version' => 'required',
       'date_creation' => 'required',
       'date_modifcation' => 'required'
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

      $project = new Project;
      $project->type = $request->input('type');
      $project->name = $request->input('name');
      $project->image = $request->input('image');
      $project->technologies = $request->input('technologies');
      $project->link = $request->input('link');
      $project->version = $request->input('version');
      $project->date_creation = $request->input('date_creation');
      $project->date_modification = $request->input('date_modification');
      $project->save();
      return response()->json([
          'status'=>200,
          'message'=>'project saved successfully', 
      ]);
    }  

    public function update (Request $request , $id){

      $validate = $this->validate_data($request);
      if($validate !== "") return $validate;

      $project = Project::find($id);
      if($project){
         $project->type = $request->input('type');
         $project->name = $request->input('name');
         $project->image = $request->input('image');
         $project->technologies = $request->input('technologies');
         $project->link = $request->input('link');
         $project->version = $request->input('version');
         $project->date_creation = $request->input('date_creation');
         $project->date_modification = $request->input('date_modification');
         $project->save();
         return response()->json([
             'status'=>200,
             'message'=>'The project has been modified successfully', 
         ]); 
      }
      else{
          return response()->json([
             'status'=>404,
             'message'=>'project id not found', 
          ]);
      }
    }

    public function findById($id){
        $project = Project::find($id);

        if($project)
        return response()->json(['status'=>200, 'project'=>$project]); 

        return response()->json(['status'=>404,'message'=>'project not found', ]); 
    }

    public function delete($id){
        $project = Project::find($id);
        if(!$project)
         return response()->json([
            'status'=>404,
            'message'=>'project id Non Trouver',
         ]); 
        $project->delete();
    }
    

    public function findAll(){
        $projects = Project::all();
        return response()->json([
            'status'=>200,
            'data'=>$projects,
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
