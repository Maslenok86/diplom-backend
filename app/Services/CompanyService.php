<?php

namespace App\Services;

class CompanyService
{
    public function getDepartmentsTree($departments){
        $departments = array_shift($departments);
        //$treeviewData = [];
        //return $departments;
        // $levelUps = $departments->filter(function ($department, $key) {
        //     //dd($department);
        //     return $department->parent_id === null;
        // });
        $levelUps = array_filter(
            $departments,
            function ($ds){
                return $ds['parent_id']===null;
            }
        );

        //return $levelUps;
        // $ddd =array_shift($departments);
        // return $ddd['title'];
        // return $levelUps;
        // $levelUps=[];
        foreach($levelUps as $levId => $levelUp){
            $treeviewData[$levId][]=[
                'id' => $levelUp['id'],
                'title' => $levelUp['title'],
                'description' => $levelUp['description'],
                'company_id' => $levelUp['company_id'],
                'parent_id' => null,
                'children' => $this->setDepartmentsChildren($departments, $levelUp['id']),
            ];
        }

        return $treeviewData;
    }

    protected function setDepartmentsChildren($departments, $parent_id)
    {
        $treeviewData = [];

        // $levelUps=$departments->filter(function ($department, $parent_id) {
        //     return $department->parent_id === $parent_id;
        // });

        $levelUps = array_filter(
            $departments,
            function ($ds) use ($parent_id){
                return $ds['parent_id']===$parent_id;
            }
        );

        foreach($levelUps as $levId => $levelUp){
            $treeviewData[$levId][]=[
                'id' => $levelUp['id'],
                'title' => $levelUp['title'],
                'description' => $levelUp['description'],
                'company_id' => $levelUp['company_id'],
                'parent_id' => $levelUp['parent_id'],
                'children' => $this->setDepartmentsChildren($departments, $levelUp['id']),
            ];
        }
        return $treeviewData;
    }
}
