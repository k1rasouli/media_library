<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
        {
            return response()->json([
                'status' => Response::HTTP_OK
            ]);
        }
        return response()->json([
            'status' => Response::HTTP_FORBIDDEN
        ]);
    }
}
