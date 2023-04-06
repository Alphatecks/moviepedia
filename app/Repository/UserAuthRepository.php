<?php

namespace App\Repository;

use App\interfaces\UserAuthRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use DB;
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

    public function email_exists(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function save_forget_password_details(array $data)
    {
        return DB::table('password_resets')->insert([
            'email' => $data['email'],
            'token' => $data['token'],
            'created_at' => Carbon::now(),
        ]);
    }
}
