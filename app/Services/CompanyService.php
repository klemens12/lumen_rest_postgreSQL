<?php

namespace App\Services;

use App\Contracts\CompanyServiceInterface;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

/**
  * Here's described methods to manipulate data follow by Company business logick.
*/
class CompanyService implements CompanyServiceInterface {

    protected $companyRepository;
   
    /**
     * Construct.
     *
     * @param CompanyRepository $companyRepository The company repository instance.
    */
    public function __construct(CompanyRepository $companyRepository) 
    {
        $this->companyRepository = $companyRepository;
    }

    
    /**
     * Get companies of auth user by relation
     *
     * @return \App\Models\User|\Exception
    */
    public function getUserCompanies()
    {
        
        $user = Auth::user();
        
        try{
            $companies = $this->companyRepository->getByUser($user);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        return $companies;
    }
    
    /**
     * Manipulate companies data and send to repository for insert to logged-ind user by relation
     *
     * @param array $companies
     * @return array|\Exception ids or Exception
    */
    public function createCompanies(array $companies)
    {
        
        try{
           $formattedData = array_map(function ($company) {
                $currentTime = Carbon::now();
                
                return [
                    'title' => $company['title'],
                    'phone' => $company['phone'],
                    'description' => $company['description'],
                    'created_at' => $currentTime,
                    'updated_at' => $currentTime
                ];
            }, $companies);
            
            $ids = $this->companyRepository->create($formattedData);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        
        return $ids;
    }
   
}
