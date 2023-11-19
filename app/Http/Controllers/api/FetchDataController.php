<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class FetchDataController extends Controller
{

  public function Send_GET_Request(Request $request){
      // Replace 'https://api.example.com' with the actual URL you want to request
      // $response = Http::get('http://yousseffarni.great-site.net/api/all_Skills', [
      //   "Cookie"=> "__test=102dc5d4d19dd6d31a07875cffedee73; expires=Thu, 31-Dec-37 23:55:55 GMT; path=/"
      // ]);

      $response = Http::withHeaders([
        'Cookie' => $request->cookie,
      ])->get('http://yousseffarni.great-site.net/api/all_Skills');

      // Access the response body as an array or JSON object
      $data = $response->json();

      return response()->json([
        'status'=>200,
        'data'=>$data,
      ]);
  }

  public function prepare_request(Request $request){
    // Replace 'https://api.example.com' with the actual URL you want to request
    // $response = Http::get('http://yousseffarni.great-site.net/api/all_Skills', [
    //   "Cookie"=> "__test=102dc5d4d19dd6d31a07875cffedee73; expires=Thu, 31-Dec-37 23:55:55 GMT; path=/"
    // ]);

    $url = 'http://yousseffarni.great-site.net/api/all_Skills';
    //$data = file_get_contents($url);

    $response = Http::withHeaders([
      'Content-Type' => "text/html",
    ])->get($request->ApiUrl);

    // Access the response body as an array or JSON object
    $data = $response->body();

    return response()->json([
      'status'=>200,
      'data'=>$data,
    ]);
  }
}
