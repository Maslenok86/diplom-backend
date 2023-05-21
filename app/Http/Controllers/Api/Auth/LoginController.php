<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Enums\RoleEnums;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Обработка попыток аутентификации.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->role_id == RoleEnums::ROLE_ADMIN){
                Auth::guard('admin')->login($user);
                $token = $user->createToken('token-admin')->plainTextToken;
                $userObject = Admin::where(['user_id' => $user->id])->first();
            }
            if($user->role_id == RoleEnums::ROLE_EMPLOYEE){
                Auth::guard('employee')->login($user);
                $token = $user->createToken('token-employee')->plainTextToken;
                $userObject = Employee::where(['user_id' => $user->id])->first();
            }
            if($user->role_id == RoleEnums::ROLE_COMPANY){
                Auth::guard('company')->login($user);
                $token = $user->createToken('token-company')->plainTextToken;
                $userObject = $user->company;
            }

            return response()->json([
                'token' => $token,
                'user' => $this->getUser($user),
                'user_object' => $userObject,
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    private function getUser(User $user)
    {
        return [
            'id'=> $user->id,
            'name'=> $user->name,
            'surname'=> null,
            'middlename'=> null,
            'email'=> $user->email,
            'role_id'=> $user->role_id,
            'phone'=> $user->phone,
            'description'=> $user->description,
        ];
    }
}
