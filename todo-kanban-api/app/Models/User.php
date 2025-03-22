<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Task;




// The User model extends Authenticatable and implements JWTSubject for JWT-based authentication
class User extends Authenticatable implements JWTSubject
{
    // Specifies the attributes that are mass assignable (can be set using create() or fill())
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();  // This function returns an array of claims that can be added to the token.

    }

    //This function returns an array of claims that can be added to the token.
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Define a one-to-many relationship with the Task model.
   public function tasks()
   {
       return $this->hasMany(Task::class); // Define a one-to-many relationship with the Task model.

   }

}
