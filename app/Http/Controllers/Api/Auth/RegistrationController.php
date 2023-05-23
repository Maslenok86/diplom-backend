<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use App\Enums\RoleEnums;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends BaseController
{
    public function registration(RegisterRequest $request)
    {
        // if(!$request->validate()){
        //     return $request;
        // }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id'],
        ]);

        if ($user->role_id == RoleEnums::ROLE_ADMIN) {
            // Создаем админа
            $admin = Admin::create([
                'user_id' => $user->id,
            ]);
        }
        if ($user->role_id == RoleEnums::ROLE_EMPLOYEE) {
            // Создаем сотрудника
            $employee = Employee::create([
                'user_id' => $user->id,
                'department_id' => $request['department_id'],
            ]);
        }
        if ($user->role_id == RoleEnums::ROLE_COMPANY) {
            // Создаем компанию
            $company = Company::create([
                'user_id' => $user->id,
                'title' => $request['title'],
                'address' => $request['company_address'],
                'phone' => $request['company_phone'],
                'email' => $request['company_email'],
            ]);

            Auth::guard('company')->login($user);
            $token = $user->createToken('token-company')->plainTextToken;
            $newToken = explode("|", $token);
            $newToken = end($newToken);
            $userObject = $user->company;

            return response()->json([
                'token' => $newToken,
                'user' => $this->getUser($user),
                'user_object' => $userObject,
            ]);
        }
        return;
    }

    private function getUser(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => null,
            'middlename' => null,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'phone' => $user->phone,
            'description' => $user->description,
        ];
    }
}
