<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminDepartment;
use App\Models\Company;
use App\Models\Department;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        return response()->json(Admin::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Admin::where(['user_id' => $request->user_id])->exists()){
            return response()->json([
                'message' => 'This admin is already exist!',
                'status' => 500
            ]);
        }
        $admin = new Admin();
        $admin->fill($request->post());

        $admin->save();
        return response()->json($admin);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return response()->json($admin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json([
            'message' => 'Success!',
            'status' => 200
        ]);
    }
}
