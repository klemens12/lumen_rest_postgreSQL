<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    protected $userService;
    
    /**
     * Construct.
     *
     * @param UserService $userService The user service instance.
    */
    public function __construct(UserService $userService = null)
    {
        $this->userService = UserService::class;
    }
    
   
    /**
     * Get the error messages for the defined validation rules(for connect translate files in future).
     *
     * @return array
    */
    public function messages() 
    {
        
        return [
          
        ];
    }
    
    /**
     * Login user by password and email.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
        ]
        , $this->messages());
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


    /**
     * Log out the user (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        
        return response()->json([
            'status' => 'ok',
            'message' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
