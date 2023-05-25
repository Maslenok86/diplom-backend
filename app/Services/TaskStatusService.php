<?php

namespace App\Services;

use App\Models\Task;

class TaskStatusService
{
    public function getTasksStatusesTree($employeeTaskStatuses)
    {
        $treeviewData = [];

        $employeeTaskStatuses = array_shift($employeeTaskStatuses);

        usort($employeeTaskStatuses, function ($a, $b) {
            return $a['task_id'] <=> $b['task_id'];
        });

        $parentTaskStatus = array_shift($employeeTaskStatuses);

        $taskInfo = Task::find($parentTaskStatus['task_id']);

        $treeviewData = $parentTaskStatus;
        $treeviewData['task_title'] = $taskInfo->title;
        $treeviewData['task_description'] = $taskInfo->description;

        $childrenTreeviewData = [];
        foreach ($employeeTaskStatuses as $childTaskStatus) {

            $taskInfo = Task::find($childTaskStatus['task_id']);

            $childrenTaskStatus = $childTaskStatus;
            $childrenTaskStatus['task_title'] = $taskInfo->title;
            $childrenTaskStatus['task_description'] = $taskInfo->description;
            $childrenTreeviewData[] = $childrenTaskStatus;
        }
        $treeviewData['children'] = $childrenTreeviewData;

        return $treeviewData;
    }



    public function getTasksTree($tasks)
    {
        $treeviewData = [];

        $tasks = array_shift($tasks);

        $parents = array_values(array_filter(
            $tasks,
            function ($task) {
                return $task['parent_id'] === null;
            }
        ));

        foreach ($parents as $parentId => $parent) {
            $treeviewData[$parentId][] = [
                'id' => $parent['id'],
                'title' => $parent['title'],
                'description' => $parent['description'],
                'parent_id' => null,
                'company_id' => $parent['company_id'],
                'children' => $this->setTasksChildren($tasks, $parent['id']),
            ];
        }

        return $treeviewData;
    }

    protected function setTasksChildren($tasks, $parent_id)
    {
        $treeviewData = [];

        $parents = array_values(array_filter(
            $tasks,
            function ($task) use ($parent_id) {
                return $task['parent_id'] === $parent_id;
            }
        ));

        foreach ($parents as $parentId => $parent) {
            $treeviewData[$parentId][] = [
                'id' => $parent['id'],
                'title' => $parent['title'],
                'description' => $parent['description'],
                'parent_id' => $parent['parent_id'],
                'company_id' => $parent['company_id'],
                //'children' => $this->setTasksChildren($tasks, $parent['id']),
            ];
        }
        return $treeviewData;
    }
}
