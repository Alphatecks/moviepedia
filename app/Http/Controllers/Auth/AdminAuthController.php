<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\interfaces\AdminAuthRepositoryInterface;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{

    public $adminRepo;

    public function __construct(AdminAuthRepositoryInterface $adminRepo)
    {
        $this->adminRepo = $adminRepo;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (!Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password',
            ]);
        }

        $admin = Admin::where('email', $request->email)->first();
        $token = $admin->createToken('myapptoken')->plainTextToken;
        return response()->json([
            'code' => 1,
            'message' => 'success',
            'type' => 'admin',
            'token' => $token,
            'data' => $admin,
        ]);
    }

    public function ChangePassword(Request $request)
    {
        $status = 401;
        $response = ['error' => 'Unauthorised'];
        $user = Auth::admin();

        if (!$user) {
            return response()->json(["error" => "Invalid user"]);
        }

        $password = $user->password;
        $old_pass = $request->currentPass;
        if (Hash::check($old_pass, $password)) {
            // The passwords match...
            $data = $request->newPass;

            $newPass = $request->admin()->fill([
                'password' => Hash::make($data),
            ])->save();
            return response()->json([
                'admin' => $newPass,
                'message' => 'Password Changed Successfully',
            ]);
        } else {
            return response()->json(['error' => $status]);
        }

    }

    public function forgotPassword(Request $request)
    {
        $token = Str::random(64);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $this->adminRepo->forgotPassword(['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]);
        //insert into password reset db

        //send mail to them
    }

    public function ResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

       $this->adminRepo->ResetPassword(["token" => $request->token, 'email' => $request->email, 'password' => $request->password]);

        return response()->json(['message' => "Password has been updated"]);

    }
}
