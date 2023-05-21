<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Company;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Task::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Company $company, Request $request)
    {
        $task = new Task();
        $task->fill($request->post());

        $task->save();

        return response()->json($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Task $task)
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Company $company, Request $request, Task $task)
    {
        $task->fill($request->post());
        $task->save();

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Success!',
            'status' => 200
        ]);
    }
}
