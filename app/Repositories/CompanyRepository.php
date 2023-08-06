<?php

namespace App\Repositories;

use App\Contracts\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface {

    /**
     * Get companies by user
     *
     * @param  \App\Models\User $user
     * @return array collection of items 
    */
    public function getByUser(\App\Models\User $user)
    {
        return $user->companies;
    }
    
    /**
     * Insert companies
     *
     * @param array $data
     * @return array $ids
    */
    public function create(array $data)
    {
        
        $ids = collect($data)->map(function ($data) {
            return Company::insertGetId($data);
        });
     
        return $ids;
    }
}
