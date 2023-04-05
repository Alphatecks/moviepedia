<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\interfaces\OTPRepositoryInterface;
use App\interfaces\UserAuthRepositoryInterface;
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
                "email" => "required|email|",
                "password" => "required|min:5|confirmed",
                'password_confirmation' => 'required|min:5',
            ]);

            if ($validator->fails()) {
                return response()->json(["code" => 3, 'error' => $validator->errors()], 401);
            }

            $user = $this->userAuthRepo->user_signup($validator->validated());

            $random = Str::random(5);

            $otp = $this->otpRepo->create_otp(["token" => $random, "user_id" => $user->id]);

            #send mail

            return response(["code" => 1, "message" => "User created successfully"]);

        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

    public function user_verification(Request $request)
    {

    }

    public function user_change_password(Request $request)
    {

    }

    public function user_forget_password(Request $request)
    {

    }

    public function user_reset_password(Request $request)
    {

    }

    public function login(Request $request){

    }

}
