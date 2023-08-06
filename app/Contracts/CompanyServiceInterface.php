<?php

namespace App\Contracts;

/**
 * Interface for manipulate business logick for Company
 */
interface CompanyServiceInterface {

    /**
     * Get companies of auth user by relation
    */
    public function getUserCompanies();

    /**
     * Manipulate companies data and send to repository for insert to logged-ind user by relation
     *
     * @param array $data
    */
    public function createCompanies(array $data);
}
