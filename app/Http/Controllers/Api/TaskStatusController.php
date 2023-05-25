<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\DepartmentService;
use App\Services\TaskStatusService;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
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
        if ($request->exists('employee_id')) {
            $taskStatus = new TaskStatus();
            $taskStatus->fill($request->post());
            $taskStatus->save();

            $tasksChildren = Task::where('parent_id', $request->task_id)->get();

            if ($tasksChildren->count() > 0) {
                foreach ($tasksChildren as $taskChild) {
                    $taskStatusChild = new TaskStatus();
                    $taskStatusChild->admin_id = $request->admin_id;
                    $taskStatusChild->employee_id = $request->employee_id;
                    $taskStatusChild->task_id = $taskChild->id;
                    $taskStatusChild->status_id = $request->status_id;

                    $taskStatusChild->save();
                }
            }
        } else if ($request->exists('department_id')) {
            $departmentService = new DepartmentService();

            $departmentsList = $departmentService->getDepartmentsList($request->department_id);
            $employeesList = $departmentService->getEmployeesList($departmentsList);

            foreach ($employeesList as $employee) {
                $taskStatus = new TaskStatus();

                $taskStatus->admin_id = $request->admin_id;
                $taskStatus->employee_id = $employee->id;
                $taskStatus->task_id = $request->task_id;
                $taskStatus->status_id = $request->status_id;

                $taskStatus->save();

                $tasksChildren = Task::where('parent_id', $request->task_id)->get();

                if ($tasksChildren->count() > 0) {
                    foreach ($tasksChildren as $taskChild) {
                        $taskStatusChild = new TaskStatus();
                        $taskStatusChild->admin_id = $request->admin_id;
                        $taskStatusChild->employee_id = $employee->id;
                        $taskStatusChild->task_id = $taskChild->id;
                        $taskStatusChild->status_id = $request->status_id;

                        $taskStatusChild->save();
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Success!',
            'status' => 200
        ]);
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


    public function getEmployeesTasks(Request $request)
    {
        $employeeTaskStatuses = TaskStatus::where('employee_id', $request->employee_id)->get();
        $taskStatusService = new TaskStatusService();

        return response()->json($taskStatusService->getTasksStatusesTree((array)$employeeTaskStatuses));
    }

    public function getAdminsTasks(Request $request)
    {
        $adminsEmployees = TaskStatus::where('admin_id', $request->admin_id)
            ->select('employee_id')->groupBy('employee_id')->get();
        $taskStatusService = new TaskStatusService();

        $employeeTaskTree = [];
        foreach ($adminsEmployees as $employee) {
            $adminsTaskStatuses = TaskStatus::where('admin_id', $request->admin_id)
                ->where('employee_id', $employee['employee_id'])->get();

            $employeeTaskTree[] = $taskStatusService->getTasksStatusesTree((array)$adminsTaskStatuses);
        }
        
        return response()->json($employeeTaskTree);
    }
}
