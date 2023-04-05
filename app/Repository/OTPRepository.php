<?php

namespace App\Repository;

use App\interfaces\OTPRepositoryInterface;
use App\Models\OTP;

class OTPRepository implements OTPRepositoryInterface
{
    public function create_otp(array $otp)
    {
        return OTP::create(["token" => $otp['token'], "user_id" => $otp['user_id']]);
    }

    public function find_token(string $token)
    {
        return OTP::where('token', $token)->first();
    }

    public function delete_token(int $id)
    {
        return OTP::find($id)->delete();
    }
}
