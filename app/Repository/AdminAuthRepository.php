<?php
declare (strict_types = 1);

namespace App\Repository;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\interfaces\AdminAuthRepositoryInterface;

class AdminAuthRepository implements AdminAuthRepositoryInterface{
    public function login(array $data){}
    public function ChangePassword(array $data);


    public function forgotPassword(array $data){
        return  DB::table('password_resets')->insert([
            'email' => $data['email'],
            'token' => $data['token'],
            'created_at' => $data['created_at'],
        ]);
    }
    public function ResetPassword(array $data){
      DB::table('password_resets')
            ->where([
                'email' => $data['email'],
                'token' => $data['token'],
            ])
            ->first();

        $user = Admin::where('email', $data['email'])->update(['password' => Hash::make($data['password'])]);
      return   DB::table('password_resets')->where(['email' => $data['email']])->delete();
    }
}
