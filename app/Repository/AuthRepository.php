<?php
namespace App\Repository;

use App\Models\User;

class AuthRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: registerUser
     * @param array $userRequest
     * @return User
     */
    public function registerUser($userRequest)
    {
        return User::create($userRequest);
    }
}
