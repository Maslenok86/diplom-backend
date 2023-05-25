<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Employee;

class DepartmentService
{
    public function getDepartmentsList($department_id)
    {
        $subDepartments = [];

        $parentDepartment = Department::find($department_id);
        $allDepartments = (array)Department::where('company_id', $parentDepartment->company_id)->get();

        $all = array_shift($allDepartments);

        $LevelUpChildren = array_values(array_filter(
            $all,
            function ($department) use ($parentDepartment) {
                return $department['parent_id'] === $parentDepartment->id;
            }
        ));

        $subDepartments[] = $parentDepartment;

        foreach ($LevelUpChildren as $child) {
            $subDepartments[] = $child;

            $levelDownChildren = array_values(array_filter(
                $all,
                function ($department) use ($child) {
                    return $department['parent_id'] === $child['id'];
                }
            ));

            if (count($levelDownChildren) > 0) {
                $lew = $this->getChildrenDepartmentsList($all, $child['id']);
                $subDepartments = array_merge($subDepartments, (array)$lew);
            }
        }

        return $subDepartments;
    }

    private function getChildrenDepartmentsList($allDepartments, $parent_id)
    {
        $subDepartments = [];

        $LevelUpChildren = array_values(array_filter(
            $allDepartments,
            function ($department) use ($parent_id) {
                return $department['parent_id'] === $parent_id;
            }
        ));

        foreach ($LevelUpChildren as $child) {
            $subDepartments[] = $child;

            $levelDownChildren = array_values(array_filter(
                $allDepartments,
                function ($department) use ($child) {
                    return $department['parent_id'] === $child['id'];
                }
            ));

            if (count($levelDownChildren) > 0) {
                $lew = $this->getChildrenDepartmentsList($allDepartments, $child['id']);
                $subDepartments = array_merge($subDepartments, (array)$lew);
            }
        }

        return $subDepartments;
    }

    public function getEmployeesList($departmentsList)
    {
        $employeesList = [];

        foreach ($departmentsList as $department) {
            $employees = (array)Employee::where('department_id', $department['id'])->get();

            if (count($employees) > 0) {
                $employeesList = array_merge($employeesList, array_shift($employees));
            }
        }
        return $employeesList;
    }
}
