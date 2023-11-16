<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class FetchDataController extends Controller
{

  public function Send_GET_Request(){
      // Replace 'https://api.example.com' with the actual URL you want to request
      $response = Http::get('http://yousseffarni.great-site.net/api/all_Skills', [
        "Cookie"=> "__test=102dc5d4d19dd6d31a07875cffedee73; XSRF-TOKEN=eyJpdiI6ImZXTHlHd1QwREtWL2tsdDNYdTEvaWc9PSIsInZhbHVlIjoiVGtaTDArTjBjZVh4ZXpWaHN0MzE3MXJzODZ2K2w5WkRJYVJpWjhiVEVjNXlHTmJsaDdQM04wMXlkOENoYkt0bExMTzRxZXN4N0dWZVJZOEZUUkxPdEo3RVl2S0J4YWN6ZzBkTkF1YTVWOWVRS2kzYVlyRGZrZFpMRTRjSFFOKzciLCJtYWMiOiIyZTQ1NTkxZjljMDU1ZGMzOGY1NDUzMTZlN2NjYTU3MmY5ZmZjYTJjNzJiNDE1MjEyMDE0ZTJmYjMyYTUyN2FmIiwidGFnIjoiIn0%3D; portfolio_youssef_session=eyJpdiI6IkFpd1lBZU5SRjRmcmwwalhjN2Zhenc9PSIsInZhbHVlIjoiSzdJakdHUFhDdklTYW0rNDdzMDR6UjZTOVovRGplYldDNGpTMFpucUFaRTdLaXEzNmUrYVp4c0lvL1pIUGhpRnlqNGlMSGhVMDBWRWZGZDFNcHl1WHFjK3JlckdSTXdrRXpsbktoN3o1dWYrKzh4N3B1OUJGa0dQZlNNUWQ5b2YiLCJtYWMiOiJlZDE1MDE2YmI1Y2NkZDYyNDU4OTJhOGQ2YWVkNDM3NGVhY2E3MzllMzI0ODc1MDUyOTBiYjZjY2NkZTBiNzg4IiwidGFnIjoiIn0%3D"
      ]);

      // Access the response body as an array or JSON object
      $data = $response;

      return response()->json([
        'status'=>200,
        'data'=>$data,
      ]);
  }

}
