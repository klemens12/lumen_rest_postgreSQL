<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\PasswordReset;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone'     
    ];
    
    protected $primaryKey = 'id';

    protected $hidden = [
        'password',
    ];

    /**
     * Load companies connected with user by relation
     * 
     * @return \App\Models\Company collection
    */
    public function companies()
    {
        return $this->belongsToMany('App\Models\Company');
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
    */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     * Insert new user
     * 
     * @param type array $data
     * @return \App\Models\User|\Exception
    */
    public static function add($data) 
    {
        
        try {
            $user = new User($data);

            if ($user->save()) {
                return $user;
            }
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    /**
     * Load PasswordReset record
     * 
     * @return \App\Models\PasswordReset collection item
    */
    public function passwordReset()
    {
        return $this->hasOne(PasswordReset::class, 'email', 'email');
    }
    
}
