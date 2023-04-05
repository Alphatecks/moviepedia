<?php

namespace App\Repository;

use App\interfaces\UserAuthRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserAuthRepository implements UserAuthRepositoryInterface
{

    public function user_signup(array $user)
    {

        return User::create([
            "email" => $user['email'],
            "password" => Hash::make($user['password']),
        ]);
    }

    public function user_verify(int $userId)
    {
        $user = User::find($userId);
        $user->email_verified_at = Carbon::now();
        return $user->save();

    }
}
