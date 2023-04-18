<?php

declare (strict_types = 1);

namespace App\interfaces;

interface AdminAuthRepositoryInterface
{
    public function login(array $data);
    public function ChangePassword(array $data);
    public function forgotPassword(array $data);
    public function ResetPassword(array $data);
}
