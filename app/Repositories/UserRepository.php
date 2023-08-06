<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;

/**
  * Here's described methods to manipulate Users data on storages/models level.
*/
class UserRepository implements UserRepositoryInterface {
    
    
    /**
     * Get user by email
     *
     * @param string $email
     * @return \App\Models\User|\Illuminate\Database\Eloquent\ModelNotFoundException
    */
    public function getByEmail(string $email) 
    {
        try{
            return User::where(["email" => $email])->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e;
        }
      
    }

    /**
     * Insert new user
     *
     * @param array $data
     * @return \App\Models\User
    */
    public function create($data) 
    {
        $user = User::add($data);

        return $user;
    }

    /**
     * Update existing User fields
     *
     * @param \App\Models\User $user
     * @param array $data
     * @return \App\Models\User
    */
    public function update(\App\Models\User $user, array $data) 
    {
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }
        
        $user->save();

        return $user;
    }

    /**
     * Attach Model items to another Model by belongsToMany relation.
     *
     * @param array $ids ids of `company_user` for example
     * @param string $belongsToManyTableName
     * @return array collection of items of another Model 
    */
    public function attach(array $ids, string $belongsToManyTableName)
    {
        switch($belongsToManyTableName){
            case 'companies':
                $user = Auth::user();
                
                $companies = $user->companies();
                $companies->attach($ids);
                
                return $user->companies;
        }
        
    }
    
}
