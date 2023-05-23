<?php

namespace App\Services;

class CompanyService
{
    public function getDepartmentsTree($departments)
    {
        $treeviewData = [];
        
        $departments = array_shift($departments);

        $parents = array_values(array_filter(
            $departments,
            function ($department) {
                return $department['parent_id'] === null;
            }
        ));

        foreach ($parents as $parentId => $parent) {
            $treeviewData[$parentId][] = [
                'id' => $parent['id'],
                'title' => $parent['title'],
                'description' => $parent['description'],
                'company_id' => $parent['company_id'],
                'parent_id' => null,
                'children' => $this->setDepartmentsChildren($departments, $parent['id']),
            ];
        }

        return $treeviewData;
    }

    protected function setDepartmentsChildren($departments, $parent_id)
    {
        $treeviewData = [];

        $parents = array_values(array_filter(
            $departments,
            function ($department) use ($parent_id) {
                return $department['parent_id'] === $parent_id;
            }
        ));

        foreach ($parents as $parentId => $parent) {
            $treeviewData[$parentId][] = [
                'id' => $parent['id'],
                'title' => $parent['title'],
                'description' => $parent['description'],
                'company_id' => $parent['company_id'],
                'parent_id' => $parent['parent_id'],
                'children' => $this->setDepartmentsChildren($departments, $parent['id']),
            ];
        }
        return $treeviewData;
    }
}
