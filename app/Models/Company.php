<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    
    protected $fillable = [
        'title',
        'phone',
        'description'
    ];
    
    public $timestamps = true;

    protected $hidden = ['pivot', 'id'];
    
    /**
     * Load users who are worked in company by relation
     * 
     * @return \App\Models\User collection
    */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'company_user', 'company_id', 'user_id');
    }
}


