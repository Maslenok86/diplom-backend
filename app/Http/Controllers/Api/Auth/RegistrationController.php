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
use Illuminate\Support\Facades\Hash;

class RegistrationController extends BaseController
{

    public function registration(RegisterRequest $request)
    {
        //dd($request->post());
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id'],
        ]);

        if($user->role_id == RoleEnums::ROLE_ADMIN){
            // Создаем админа
            $admin = Admin::create([
                'user_id' => $user->id,
            ]);
        }
        if($user->role_id == RoleEnums::ROLE_EMPLOYEE){
            // Создаем сотрудника
            $employee = Employee::create([
                'user_id' => $user->id,
                'department_id' => $request['department_id'],
            ]);
        }
        return;
    }

}
