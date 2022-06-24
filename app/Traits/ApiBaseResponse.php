<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiBaseResponse {

    public function success($data = ["message" => "Success!"] , $code = Response::HTTP_OK)
    {
        return response()->json($data , $code);
    }


    public function error($data = ["message" => "Error!"] , $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json($data , $code);
    }
}
