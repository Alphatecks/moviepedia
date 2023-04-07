<?php

declare (strict_types = 1);

namespace App\Custom;

use App\Mail\UserForgetPasswordMail;
use App\Mail\UserVerificationMail;
use Illuminate\Support\Facades\Mail;

class MailMessages
{
    public static function UserVerificationMail(string $email, string $token)
    {
        $subject = "Email Verification Notification";
        $message = "Below is the OTP for account and email verification \n";
        $OTP = "OTP: {$token}";

        $mailData = ["subject" => $subject, "message" => $message, "OTP" => $OTP];

        Mail::to($email)->send(new UserVerificationMail($mailData));
    }

    public static function UserForgetPasswordMail(string $email, string $token)
    {
        $subject = "Forget Password Notification";
        $message = "Below is the OTP for your password reset.

        Kindly ignore if this mail isn't from you.";

        $mailData = ["subject" => $subject, "message" => $message, "token" => $token];

        Mail::to($email)->send(new UserForgetPasswordMail($mailData));

    }
}
