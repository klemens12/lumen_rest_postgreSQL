<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CompanyController extends Controller
{
    protected $companyService;
    protected $userService;
     
   /**
     * Construct.
     *
     * @param CompanyService $companyService The company service instance.
     * @param UserService $userService The user service instance.
    */
    public function __construct(CompanyService $companyService, UserService $userService)
    {
        
        $this->companyService = $companyService;
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
     * Load user companies by relation
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function index()
    {
        
        $result = $this->companyService->getUserCompanies();
       
        if (is_object($result)) {
            return response()->json(['status' => 'ok', 'message' => $result]);
        }
    }
    
    /**
     * Create new companies to auth user and attaches then by relation to him
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function createAttach(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
           'companies' => 'required|array',
            'companies.*.title' => 'required|string|max:255',
            'companies.*.phone' => 'required|string|max:255',
            'companies.*.description' => 'required|string|max:255'
        ]
        , $this->messages());
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }
        
        $createdIds = $this->companyService->createCompanies($request->companies);
       
        if(is_object($createdIds)){
            $res = $this->userService->attachCreated($createdIds->toArray());
            
            return response()->json(['status' => 'ok', 'message' => $res ]);
        }
        
        return response()->json(['status' => 'error', 'message' => $createdIds], 400);
    }
}
