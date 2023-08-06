<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $userService;


    /**
     * Construct.
     *
     * @param UserService $userService The user service instance.
    */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
     * Registration new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|string'
        ]
        , $this->messages());
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        try {
            $user = $this->userService->registerUser($request->all());

            if (is_object($user)) {
                $authc = new AuthController();
                
                return $authc->login($request);
            } 
             return response()->json(['status' => 'error', 'message' => $user]);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * Create and user password reset token via email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function addResetToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]
        , $this->messages());
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }
        
        $user = $this->userService->getUserByEmail($request->email);
        if($user instanceof User){
            $result = $this->userService->addResetToken($user);
           
            if(is_object($result)){
                return response()->json(['status' => 'ok', 'token_to_reset' => $result->token]);
            }
            
            return response()->json(['status' => 'error', 'message' => $result], 400);
        } else{
            return response()->json(['status' => 'error', 'message' => $user->getMessage()], 400);
        }
    }
    
    /**
     * Reset user password via email token generated in addResetToken()
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|size:255'
        ]
        , $this->messages());
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }
        
        $result = $this->userService->getRestoreRecordByToken($request->token);
        
        if(is_object($result)){
            $updatedUser = $this->userService->regenerateUserPassword($result['user']);
            
            if(is_object($result)){
                $this->userService->deleteRestoreRecord($request->token);
                
                return response()->json(['status' => 'ok', 'message' => ['new_password' => $updatedUser['new_password']]]);
            }
            
            return response()->json(['status' => 'error', 'message' => $updatedUser], 400);
        }
        
        return response()->json(['status' => 'error', 'message' => $result], 400);
    }
}