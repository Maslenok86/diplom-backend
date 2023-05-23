<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminDepartment;
use Illuminate\Http\Request;

class AdminDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $adminDepartment = new AdminDepartment();
        $adminDepartment->fill($request->post());

        // dd($adminDepartment);
        $adminDepartment->save();

        //$adminDepartment = new AdminDepartment();
        // Admin::find($request->admin_id)->departments()->attach($request->department_id);

        // $tt = AdminDepartment::all();

        // $adminDepartment = new AdminDepartment();
        // $adminDepartment->admin_id = $request->admin_id;
        // $adminDepartment->department_id = $request->department_id;

        // $adminDepartment->save();
        return response()->json($adminDepartment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
