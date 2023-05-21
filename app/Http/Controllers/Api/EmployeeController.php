<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return response()->json(Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Employee::where(['user_id' => $request->user_id])->exists()){
            return response()->json([
                'message' => 'This employee is already exist!',
                'status' => 500
            ]);
        }
        $employee = new Employee();
        $employee->fill($request->post());

        $employee->save();
        return response()->json($employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'message' => 'Success!',
            'status' => 200
        ]);
    }
}
