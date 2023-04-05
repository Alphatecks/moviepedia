<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\interfaces\UserAuthRepositoryInterface;

class UserAuthRepository implements UserAuthRepositoryInterface
{

    public function user_signup(array $user)
    {
        return User::create([
            "email" => $user['email'],
            "password" => Hash::make($user['password']),
        ]);
    }
}
