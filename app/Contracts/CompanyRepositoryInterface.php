<?php

namespace App\Contracts;
use App\Models\User;

/**
 * Interface for manipulate data layer on storages/models level for Company.
 */
interface CompanyRepositoryInterface {

    /**
     * Get companies by user
     *
     * @param \App\Models\User $user
    */
    public function getByUser(\App\Models\User $user);

    /**
     * Insert companies
     *
     * @param array $data
    */
    public function create(array $data);

}
