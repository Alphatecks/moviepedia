<?php

declare (strict_types = 1);

namespace App\Custom;

use App\Mail\UserVerificationMail;
use Illuminate\Support\Facades\Mail;

class MailMessages
{
    public static function UserVerificationMail(string $email, string $token)
    {
        $subject = "Email Verification Notification";
        $message = "Below is the OTP for account and email verification";
        $message .= "OTP: {$token}";

        Mail::to($email)->send(new UserVerificationMail($subject, $message));
    }
}
