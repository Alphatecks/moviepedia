<?php

namespace App\Http\Controllers\Auth;

use App\Custom\ApiResponseTrait;
use App\Custom\MailMessages;
use App\Http\Controllers\Controller;
use App\interfaces\OTPRepositoryInterface;
use App\interfaces\UserAuthRepositoryInterface;
use App\Mail\UserVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;
use Validator;

class UserAuthController extends Controller
{

    use ApiResponseTrait;

    private $userAuthRepo;
    private $otpRepo;

    public function __construct(UserAuthRepositoryInterface $userAuthRepo, OTPRepositoryInterface $otpRepo)
    {
        $this->userAuthRepo = $userAuthRepo;
        $this->otpRepo = $otpRepo;
    }
    public function user_signup(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "firstname" => [],
                "middlename" => [],
                "lastname" => [],
                "email" => "required|email|unique:users",
                "password" => "required|min:5|confirmed",
                'password_confirmation' => 'required|min:5',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

            $user = $this->userAuthRepo->user_signup($validator->validated());

            $random = Str::random(6);

            $otp = $this->otpRepo->create_otp(["token" => $random, "user_id" => $user->id]);

            #send mail

            MailMessages::UserVerificationMail($request->email, $random);

            return $this->success("User created successfully");
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function user_verification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'verify_token' => ['required', 'string', 'max:200'],

            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

            $token_exists = $this->otpRepo->find_token($request->verify_token);

            if ($token_exists == null) {
                return $this->error("The token doesn't exist", 401);
            }

            $update_user_verification = $this->userAuthRepo->user_verify($token_exists->user_id);

            if ($update_user_verification) {
                $this->otpRepo->delete_token($token_exists->id);
            }

            return $this->success("user verification successful");

        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function user_change_password(Request $request)
    {
        try {
            # validate user inputs
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => ['required', 'string', 'min:4', 'confirmed'],
            ]);

            # check if validation fails
            if ($validator->fails()) {
                # return validation error
                return $this->error($validator->errors(), 401);
            }
            # check if the user is authenticated
            if (auth()->user()) {
                try {
                    # checking if the password matches with current password in use
                    if (password_verify(request('current_password'), auth()->user()->password)) {
                        # update the new password
                        auth()->user()->update(['password' => Hash::make(request('password'))]);
                        # return success message after updating
                        return $this->success("Password update successful");
                    } else {
                        return $this->error("password mismatch", 401);
                    }
                } catch (\Throwable$e) {
                    return $this->error($th->getMessage(), 400);
                }
            } else {
                return $this->error("Unauthenticated user", 400);
            }
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function user_forget_password(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

            $email_exists = $this->userAuthRepo->email_exists($request->email);

            if ($email_exists == null) {
                return $this->error("Email does not exist", 401);
            }

            $random = Str::random(6);

            $this->userAuthRepo->save_forget_password_details(["email" => $request->email, "token" => $random]);

            #send mail

            MailMessages::UserForgetPasswordMail($request->email, $random);

            return $this->success("email sent successfully", 201);
        } catch (\Throwable$th) {

            return $this->error($th->getMessage(), 400);
        }
    }

    public function user_reset_password(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

            $update_password = $this->userAuthRepo->update_password($validator->validated());

            return $this->success("Password reset successful");

        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

            if (!auth()->attempt($request->only(['email', 'password']))) {
                return $this->error("Invalid email or password", 401);
            }

            $user = $this->userAuthRepo->is_user_active($request->email);

            if ($user) {
                $status = 200;

                $response = [
                    'type' => 'user',
                    // 'user_auth_type' => ($user->password != null) ? 'main' : 'google',
                    'user' => auth()->user(),
                    'token' => auth()->user()->createToken('auth_token')->plainTextToken,
                ];
                return $this->success("Login successful", $response);
            } else {
                return $this->error("No user with this email OR account is yet to be verified", 400);
            }

        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

}
