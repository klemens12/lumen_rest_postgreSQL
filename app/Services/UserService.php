<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Repositories\UserRepository;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\PasswordReset;

/**
  * Here's described methods to manipulate data follow by User business logick.
*/
class UserService implements UserServiceInterface {

    protected $userRepository;
    
    protected $passwMinMaxLength = ["min" => 6, "max" => 20];
    
    /**
     * Construct.
     *
     * @param UserRepository $userRepository The user repository instance.
    */
    public function __construct(UserRepository $userRepository) 
    {
        
        $this->userRepository = $userRepository;
    }

   
    /**
     * Get user by email.
     *
     * @param string $email
     * @return \App\Models\User|\Exception 
    */
    public function getUserByEmail(string $email) 
    {
        
        return $this->userRepository->getByEmail($email);
    }
    
    /**
     * Registration new user.
     *
     * @param array $data
     * @return \App\Models\User|\Exception 
    */
    public function registerUser(array $data) 
    {

        $userData = [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "password" => app('hash')->make($data['password']),
            "phone" => $data['phone']
           
        ];
      
        return $this->userRepository->create($userData);
    }
    
    /**
     * Regenerate user password by model.
     *
     * @param \App\Models\User $user
     * @return array
    */
    public function regenerateUserPassword(\App\Models\User $user) 
    {
        
        $newPassword = Str::random(rand($this->passwMinMaxLength["min"], $this->passwMinMaxLength["max"]));
        
        $userData = [
            "password_hash" => app('hash')->make($newPassword),
            "password_pure" => $newPassword
        ];

        $resUpdate = $this->userRepository->update($user, ["password" => $userData["password_hash"]]);
        
        return [
            "result_update" => $resUpdate,
            "new_password" => $userData["password_pure"]
        ];
    }
    
    
    /**
     * Create password reset token record
     *
     * @param \App\Models\User $user
     * @return object|\Exception 
    */
    public function addResetToken(\App\Models\User $user) 
    {
        
        $resetData = [
            "email" => $user['email'],
            "token" => Str::random(255),
            "created_at" => Carbon::now()
        ];

        return PasswordReset::add($resetData);
    }
    
    /**
     * Get PasswordReset item by token
     *
     * @param string $token
     * @return \App\Models\PasswordReset|\Exception 
    */
    public function getRestoreRecordByToken(string $token)
    {
        
        try{
            return PasswordReset::where(["token" => $token])->with(['user'])->firstOrFail();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    /**
     * Delete already used PasswordReset record by token
     *
     * @param string $token
     * @return bool|\Exception 
    */
    public function deleteRestoreRecord(string $token)
    {
        
        try{
            return PasswordReset::where(["token" => $token])->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    /**
     * Attach created company ids to user by relation.
     *
     * @param array $ids
     * @return array|\Exception 
    */
    public function attachCreated(array $ids)
    {
       
        try{
            return $this->userRepository->attach($ids, 'companies');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
     
    }
}
