<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiBaseResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    use ApiBaseResponse;

    public function show()
    {
        return $this->success([
            'message' => 'User profile retrieved successfully',
            'data' => UserResource::make(auth()->user())
        ]);
    }
}
