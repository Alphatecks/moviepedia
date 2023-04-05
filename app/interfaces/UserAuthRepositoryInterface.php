<?php

declare (strict_types = 1);

namespace App\interfaces;

interface UserAuthRepositoryInterface
{
    public function user_signup(array $user);
    public function user_verify(int $userId);
}
