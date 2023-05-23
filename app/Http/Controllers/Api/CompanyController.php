<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Company::all());
        //Company::where(['user_id' => Auth::user()->id])->first();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = new Company();
        $company->fill($request->post());

        $company->save();

        return response()->json($company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $departments = $company->departments;
        $companyService = new CompanyService();

        return response()->json($companyService->getDepartmentsTree((array)$departments));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $company->fill($request->post());
        $company->save();

        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Success!',
            'status' => 200
        ]);
    }

    public function getUsers(Company $company, Request $request)
    {
        return response()->json($company->users);
    }
}
