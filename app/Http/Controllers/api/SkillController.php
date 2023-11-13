<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Icon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    private function validate_data ($request){
      $validator = Validator::make($request-> all(), [
       'name'  => 'required',
       'percentage'  => 'required',
       'icon'  => 'required',
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

      $skill = new Skill;
      $skill->name = $request->input('name');
      $skill->percentage = $request->input('percentage');
      $skill->icon = $request->input('icon');
      $skill->save();
      return response()->json([
          'status'=>200,
          'message'=>'skill saved successfully', 
      ]);
    }  

    public function update (Request $request , $id){

      $validate = $this->validate_data($request);
      if($validate !== "") return $validate;

      $skill = Skill::find($id);
      if($skill){
        $skill->name = $request->input('name');
        $skill->percentage = $request->input('percentage');
        $skill->icon = $request->input('icon');
        $skill->save();
        return response()->json([
          'status'=>200,
          'message'=>'The skill has been modified successfully', 
        ]); 
      }
      else{
        return response()->json([
          'status'=>404,
          'message'=>'skill id not found', 
        ]);
      }
    }

    public function findById($id){
      $skill = Skill::find($id);

      if($skill)
      return response()->json(['status'=>200, 'project'=>$skill]); 

      return response()->json(['status'=>404,'message'=>'skill not found', ]); 
    }

    public function delete($id){
      $skill = Skill::find($id);
      if(!$skill)
       return response()->json([
        'status'=>404,
        'message'=>'skill id Non Trouver',
       ]); 
      $skill->delete();
    }
    

    public function findAll(){
      $skills = Skill::all();

      foreach($skills as $skill){
        $icon = Icon::where('id', $skill->icon_id)->first();
        $skill->icon = $icon->icon;
      }

      return response()->json([
        'status'=>200,
        'data'=>$skills,
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
