<?php

declare (strict_types = 1);

namespace App\interfaces;

interface OTPRepositoryInterface
{
    public function create_otp(array $otp);
    public function find_token(string $token);
    public function delete_token(int $id);
}
