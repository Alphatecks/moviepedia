<?php

namespace App\Http\Controllers\Auth;

use App\Custom\MailMessages;
use App\Http\Controllers\Controller;
use App\interfaces\OTPRepositoryInterface;
use App\interfaces\UserAuthRepositoryInterface;
use App\Mail\UserVerificationMail;
use Illuminate\Http\Request;
use Str;
use Validator;

class UserAuthController extends Controller
{

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
                return response()->json(["code" => 3, 'error' => $validator->errors()], 401);
            }

            $user = $this->userAuthRepo->user_signup($validator->validated());

            $random = Str::random(6);

            $otp = $this->otpRepo->create_otp(["token" => $random, "user_id" => $user->id]);

            #send mail

            MailMessages::UserVerificationMail($request->email, $random);

            return response(["code" => 1, "message" => "User created successfully"], 201);

        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

    public function user_verification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'verify_token' => ['required', 'string', 'max:200'],

            ]);

            if ($validator->fails()) {
                return response()->json(["code" => 3, 'error' => $validator->errors()], 401);
            }

            $token_exists = $this->otpRepo->find_token($request->verify_token);

            if ($token_exists->count() == 0) {
                return response(["code" => 3, "The provided token does not exist"]);
            }

            $update_user_verification = $this->userAuthRepo->user_verify($token_exists->user_id);

            if ($update_user_verification) {
                $this->otpRepo->delete_token($token_exists->id);
            }

            return response([""]);

        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
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
                return response()->json(["code" => 3, 'error' => $validator->errors()], 401);
            }
            # check if the user is authenticated
            if (auth()->user()) {
                try {
                    # checking if the password matches with current password in use
                    if (password_verify(request('current_password'), auth()->user()->password)) {
                        # update the new password
                        auth()->user()->update(['password' => Hash::make(request('password'))]);
                        # return success message after updating
                        return response()->json([
                            'code' => 1,
                            'data' => [
                                'message' => 'password changed.',
                            ],
                        ]);
                    } else {
                        return response()->json([
                            'code' => 3,
                            'message' => 'password mismatch',
                        ]);
                    }
                } catch (\Throwable$e) {
                    return response()->json([
                        'code' => 3,
                        'error ' => $e->getMessage(),
                    ], 500);
                }
            } else {
                return response()->json([
                    'code' => 3,
                    'message' => 'unauthenticated user',
                ], 401);
            }
        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

    public function user_forget_password(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);

            if ($validator->fails()) {
                return response()->json(["code" => 3, 'error' => $validator->errors()], 401);
            }

            $email_exists = $this->userAuthRepo->email_exists($request->email);

            if ($email_exists == null) {
                return response(["code" => 3, "message" => "email does not exist"], 401);
            }

            $random = Str::random(6);

            $this->userAuthRepo->save_forget_password_details(["email" => $request->email, "token" => $random]);

            #send mail

        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

    public function user_reset_password(Request $request)
    {
        try {
            //code...
        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            //code...
        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

}
