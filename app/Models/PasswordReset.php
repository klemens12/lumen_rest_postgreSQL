<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {

    protected $table = 'password_resets';
    
    protected $fillable = [
        'email', 
        'token', 
        'created_at'
    ];
    
    protected $primaryKey = null;
    
    public $incrementing = false;

    /**
     * Load user by relation
     * 
     * @return \App\Models\User collection item
    */
    public function user() 
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Insert new record
     * 
     * @param array $data
     * @return \App\Models\PasswordReset|\Exception
    */
    public static function add($data) 
    {
        
        try {

            $passwordReset = new PasswordReset($data);

            if ($passwordReset->save()) {
                return $passwordReset;
            }
        } catch (\Exception $e) {
             return $e->getMessage();
        }
    }

}
