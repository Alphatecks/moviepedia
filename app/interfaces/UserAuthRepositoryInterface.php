<?php

declare (strict_types = 1);

namespace App\interfaces;

interface UserAuthRepositoryInterface
{
    public function user_signup(array $user);
    public function user_verify(int $userId);
    public function email_exists(string $email);
    public function save_forget_password_details(array $data);
    public function update_password(array $data);
    public function is_user_active(string $email);
}
