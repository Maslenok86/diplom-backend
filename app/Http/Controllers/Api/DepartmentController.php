<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        return response()->json($company->departments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Company $company, Request $request)
    {
        $department = new Department();
        $department->fill($request->post());

        $department->save();

        return response()->json($department);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Department $department)
    {
        return response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Company $company, Request $request, Department $department)
    {
        $department->fill($request->post());
        $department->save();

        return response()->json($department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Department $department)
    {
        $department->delete();

        return response()->json([
            'message' => 'Success!',
            'status' => 200
        ]);
    }
}
