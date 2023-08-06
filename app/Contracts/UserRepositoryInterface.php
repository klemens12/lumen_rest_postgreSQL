<?php

namespace App\Contracts;

/**
 * Interface for manipulate data layer on storages/models level for Users.
 */
interface UserRepositoryInterface {

    /**
     * Get user by email
     *
     * @param string $email
    */
    public function getByEmail(string $email);

    /**
     * Insert new user
     *
     * @param array $data
    */
    public function create($data);

    /**
     * Update existing User fields
     *
     * @param \App\Models\User $user
     * @param array $data
    */
    public function update(\App\Models\User $user, array $data);

    /**
     * Attach Model items to another Model by belongsToMany relation.
     *
     * @param array $ids ids of `company_user` for example
     * @param string $belongsToManyTableName
    */
    public function attach(array $ids, string $belongsToManyTableName);
}
