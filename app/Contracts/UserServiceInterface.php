<?php

namespace App\Contracts;

/**
 * Interface for manipulate business logick for Users
 */
interface UserServiceInterface {

    /**
     * Get user by email.
     *
     * @param string $email
    */
    public function getUserByEmail(string $email);

    /**
     * Registration new user.
     *
     * @param array $data
    */
    public function registerUser(array $data);

    /**
     * Regenerate user password by model.
     *
     * @param \App\Models\User $user
    */
    public function regenerateUserPassword(\App\Models\User $user);

    /**
     * Create password reset token record
     *
     * @param \App\Models\User $user
    */
    public function addResetToken(\App\Models\User $user);
    
    /**
     * Get PasswordReset item by token
     *
     * @param string $token
    */
    public function getRestoreRecordByToken(string $token);
    
    /**
     * Delete already used PasswordReset record by token
     *
     * @param string $token
    */
    public function deleteRestoreRecord(string $token);
    
    /**
     * Attach created company ids to user by relation.
     *
     * @param array $ids
    */
    public function attachCreated(array $ids);
    
    
}
